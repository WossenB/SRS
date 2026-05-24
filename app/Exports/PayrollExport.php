<?php

namespace App\Exports;

use App\Models\PayrollItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PayrollExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(public int $payrollRunId)
    {
    }

    public function collection()
    {
        return PayrollItem::where('payroll_run_id', $this->payrollRunId)
            ->with('employee')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Employee ID',
            'Full Name',
            'Basic Salary',
            'Gross Salary',
            'Taxable Income',
            'Income Tax',
            'Pension (Employee)',
            'Net Pay',
        ];
    }

    public function map($item): array
    {
        return [
            $item->employee->employee_id,
            $item->employee->first_name . ' ' . $item->employee->last_name,
            $item->basic_salary,
            $item->gross_salary,
            $item->taxable_income,
            $item->income_tax,
            $item->pension_employee,
            $item->net_pay,
        ];
    }
}
