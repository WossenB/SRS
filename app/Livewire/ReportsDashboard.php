<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Applicant;
use App\Models\TrainingAssignment;
use Illuminate\Support\Facades\DB;

class ReportsDashboard extends Component
{
    public function render()
    {
        $turnover = Employee::where('status', 'terminated')->whereYear('updated_at', now()->year)->count();
        $hires = Employee::whereYear('hire_date', now()->year)->count();

        $recruitmentStats = Applicant::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return view('livewire.reports-dashboard', [
            'turnover' => $turnover,
            'hires' => $hires,
            'recruitmentStats' => $recruitmentStats,
            'trainingCompletion' => TrainingAssignment::where('status', 'completed')->count(),
        ])->layout('layouts.app');
    }
}
