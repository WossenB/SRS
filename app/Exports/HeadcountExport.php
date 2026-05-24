<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HeadcountExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Employee::with(['department', 'position'])
            ->get()
            ->map(function ($employee) {
                return [
                    'ID' => $employee->employee_id,
                    'Name' => $employee->first_name . ' ' . $employee->last_name,
                    'Department' => $employee->department?->name,
                    'Position' => $employee->position?->title,
                    'Hire Date' => $employee->hire_date->format('Y-m-d'),
                    'Status' => $employee->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Employee ID',
            'Full Name',
            'Department',
            'Position',
            'Hire Date',
            'Status',
        ];
    }
}
