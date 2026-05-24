<?php

namespace App\Exports;

use App\Models\PayrollItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BankExport implements FromCollection, WithHeadings
{
    public function __construct(public int $payrollRunId) {}

    public function collection()
    {
        return PayrollItem::where('payroll_run_id', $this->payrollRunId)
            ->with('employee')
            ->get()
            ->map(fn($item) => [
                'Account Name' => "{$item->employee->first_name} {$item->employee->last_name}",
                'Account Number' => $item->employee->bank_details, // Decrypted in model
                'Amount' => $item->net_pay,
                'Currency' => 'ETB',
                'Reference' => "Salary-{$item->payrollRun->period_month}"
            ]);
    }

    public function headings(): array
    {
        return ['Account Name', 'Account Number', 'Amount', 'Currency', 'Reference'];
    }
}
