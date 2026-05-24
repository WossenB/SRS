<?php

namespace App\Livewire\Leave;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LeaveRequest;
use App\Services\LeaveService;
use Illuminate\Support\Facades\Auth;

class LeaveApprovalManager extends Component
{
    use WithPagination;

    public function approve(int $leaveId)
    {
        $leave = LeaveRequest::findOrFail($leaveId);

        $this->authorize('approve', $leave);

        $service = new LeaveService();
        $service->approveByManager($leave, Auth::id());

        session()->flash('success', 'Leave request approved!');
    }

    public function reject(int $leaveId)
    {
        $leave = LeaveRequest::findOrFail($leaveId);

        $this->authorize('approve', $leave);

        $leave->logStatusChange('rejected', $leave->status, ['rejected_by' => Auth::id()]);

        session()->flash('success', 'Leave request rejected!');
    }

    public function render()
    {
        $managedEmployeeIds = Auth::user()->employee?->managedEmployees()->pluck('id') ?? [];

        $pendingLeaves = LeaveRequest::whereIn('employee_id', $managedEmployeeIds)
            ->where('status', 'submitted')
            ->with(['employee', 'leaveType'])
            ->paginate(10);

        return view('livewire.leave.leave-approval-manager', [
            'pendingLeaves' => $pendingLeaves
        ])->layout('layouts.app');
    }
}
