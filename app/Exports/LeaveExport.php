<?php

namespace App\Exports;

use App\Models\LeaveRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeaveExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return LeaveRequest::with(['employee', 'leaveType'])
            ->get()
            ->map(fn($l) => [
                'Employee' => $l->employee->first_name . ' ' . $l->employee->last_name,
                'Type' => $l->leaveType->name,
                'Start' => $l->start_date->format('Y-m-d'),
                'End' => $l->end_date->format('Y-m-d'),
                'Days' => $l->days_requested,
                'Status' => $l->status,
            ]);
    }

    public function headings(): array
    {
        return ['Employee', 'Type', 'Start Date', 'End Date', 'Days', 'Status'];
    }
}
