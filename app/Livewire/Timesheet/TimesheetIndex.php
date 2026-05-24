<?php

namespace App\Livewire\Timesheet;

use Livewire\Component;
use App\Models\Timesheet;
use Illuminate\Support\Facades\Auth;

class TimesheetIndex extends Component
{
    public function render()
    {
        $timesheets = Timesheet::where('employee_id', Auth::user()->employee?->id)
            ->latest()
            ->get();

        return view('livewire.timesheet.timesheet-index', [
            'timesheets' => $timesheets
        ])->layout('layouts.app');
    }
}
