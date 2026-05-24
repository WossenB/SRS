<?php

namespace App\Livewire\Timesheet;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Timesheet;
use App\Services\TimesheetService;
use Illuminate\Support\Facades\Auth;

class TimesheetApproval extends Component
{
    use WithPagination;

    public function approve(int $id)
    {
        $timesheet = Timesheet::findOrFail($id);
        $this->authorize('approve', $timesheet);

        $service = new TimesheetService();
        $service->approveBySupervisor($timesheet);

        session()->flash('success', 'Timesheet approved.');
    }

    public function render()
    {
        $managedEmployeeIds = Auth::user()->employee?->managedEmployees()->pluck('id') ?? [];

        $pendingTimesheets = Timesheet::whereIn('employee_id', $managedEmployeeIds)
            ->where('status', 'submitted')
            ->with('employee')
            ->paginate(10);

        return view('livewire.timesheet.timesheet-approval', [
            'pendingTimesheets' => $pendingTimesheets
        ])->layout('layouts.app');
    }
}
