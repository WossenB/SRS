<?php

namespace App\Services;

use App\Models\PayrollRun;
use App\Models\PayrollItem;
use App\Models\Employee;
use App\Models\TaxSlab;
use App\Models\PensionRate;
use App\Models\EmployeeBenefit;
use App\Support\Money;
use Illuminate\Support\Facades\DB;
use App\Traits\HasStatusHistory;

class PayrollService
{
    /**
     * Run payroll for a given period.
     * SRS Ref: FR-PAY-01-06, 6.2
     */
    public function initiateRun(string $periodMonth, string $runType = 'regular', int $userId)
    {
        return DB::transaction(function () use ($periodMonth, $runType, $userId) {
            // Idempotency check
            if (PayrollRun::where('period_month', $periodMonth)->where('run_type', $runType)->exists()) {
                throw new \Exception("Payroll run for this period already exists.");
            }

            // Snapshot tax slabs and pension rates
            $slabs = TaxSlab::all()->toArray();
            $pension = PensionRate::where('is_active', true)->first();

            $payrollRun = PayrollRun::create([
                'period_month' => $periodMonth,
                'run_type' => $runType,
                'processed_by' => $userId,
                'status' => 'draft',
                'input_snapshot' => json_encode([
                    'tax_slabs' => $slabs,
                    'pension_rate' => $pension ? $pension->toArray() : null,
                ]),
            ]);

            $employees = Employee::where('status', 'active')->get();

            $totalGross = 0;
            $totalNet = 0;

            foreach ($employees as $employee) {
                $item = $this->calculateEmployeePayroll($employee, $slabs, $pension);
                $item['payroll_run_id'] = $payrollRun->id;
                $item['employee_id'] = $employee->id;

                PayrollItem::create($item);

                $totalGross += $item['gross_salary'];
                $totalNet += $item['net_pay'];
            }

            // SRS: Rounding Drift Validation
            // sum of individual net should match total net within small epsilon
            $sumOfItems = PayrollItem::where('payroll_run_id', $payrollRun->id)->sum('net_pay');
            if (abs($sumOfItems - $totalNet) > 0.05) {
                throw new \Exception("Rounding drift detected. Audit required.");
            }

            $payrollRun->update([
                'total_gross' => $totalGross,
                'total_net' => $totalNet,
            ]);

            return $payrollRun;
        });
    }

    public function lockPayrollRun(PayrollRun $payrollRun, int $userId)
    {
        return DB::transaction(function () use ($payrollRun, $userId) {
            $payrollRun->status = 'locked';
            $payrollRun->save();

            $payrollRun->logStatusChange('locked', 'draft', [
                'approved_by' => $userId,
                'action' => 'Final approval'
            ]);

            return $payrollRun;
        });
    }

    private function calculateEmployeePayroll(Employee $employee, array $slabs, ?PensionRate $pension)
    {
        $basicSalary = (float) $employee->basic_salary;

        $benefits = EmployeeBenefit::where('employee_id', $employee->id)
            ->where('is_active', true)
            ->with('catalog')
            ->get();

        $taxableBenefits = 0;
        $nonTaxableBenefits = 0;

        foreach ($benefits as $benefit) {
            if ($benefit->catalog->is_taxable) {
                $taxableBenefits += (float)$benefit->amount;
            } else {
                $nonTaxableBenefits += (float)$benefit->amount;
            }
        }

        $pensionEmployee = 0;
        $pensionEmployer = 0;
        if ($pension) {
            $pensionEmployee = Money::roundPension($basicSalary * ($pension->employee_rate / 100));
            $pensionEmployer = Money::roundPension($basicSalary * ($pension->employer_rate / 100));
        }

        $grossSalary = $basicSalary + $taxableBenefits + $nonTaxableBenefits;
        $taxableIncome = ($basicSalary + $taxableBenefits) - $pensionEmployee;

        $incomeTax = $this->calculateIncomeTax($taxableIncome, $slabs);

        $netPay = Money::roundNet($taxableIncome - $incomeTax + $nonTaxableBenefits);

        return [
            'basic_salary' => $basicSalary,
            'gross_salary' => $grossSalary,
            'taxable_income' => $taxableIncome,
            'income_tax' => $incomeTax,
            'pension_employee' => $pensionEmployee,
            'pension_employer' => $pensionEmployer,
            'net_pay' => $netPay,
            'adjustments' => json_encode(['benefits' => $benefits->pluck('amount', 'catalog.name')])
        ];
    }

    private function calculateIncomeTax(float $taxableIncome, array $slabs)
    {
        foreach ($slabs as $slab) {
            if ($taxableIncome >= $slab['min_income'] && ($slab['max_income'] === null || $taxableIncome <= $slab['max_income'])) {
                return Money::roundTax(($taxableIncome * ($slab['rate'] / 100)) - $slab['deduction']);
            }
        }
        return 0;
    }
}
