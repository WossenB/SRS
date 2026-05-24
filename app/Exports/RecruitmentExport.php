<?php

namespace App\Exports;

use App\Models\Applicant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RecruitmentExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Applicant::with('jobOpening')
            ->get()
            ->map(fn($a) => [
                'Name' => $a->first_name . ' ' . $a->last_name,
                'Job' => $a->jobOpening->title,
                'Email' => $a->email,
                'Status' => $a->status,
                'Applied' => $a->created_at->format('Y-m-d'),
            ]);
    }

    public function headings(): array
    {
        return ['Name', 'Job Opening', 'Email', 'Status', 'Applied Date'];
    }
}
