<?php

namespace App\Services;

use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Support\Facades\DB;
use App\Traits\HasStatusHistory;

class LeaveService
{
    /**
     * Submit a leave request with overlap and balance validation.
     * SRS Ref: FR-LEAVE-01-05
     */
    public function submitRequest(array $data)
    {
        return DB::transaction(function () use ($data) {
            $employee = Employee::findOrFail($data['employee_id']);
            $leaveType = LeaveType::findOrFail($data['leave_type_id']);

            // 1. Check for overlaps
            $overlap = LeaveRequest::where('employee_id', $employee->id)
                ->whereNotIn('status', ['rejected', 'cancelled'])
                ->where(function ($query) use ($data) {
                    $query->whereBetween('start_date', [$data['start_date'], $data['end_date']])
                          ->orWhereBetween('end_date', [$data['start_date'], $data['end_date']])
                          ->orWhere(function ($q) use ($data) {
                              $q->where('start_date', '<=', $data['start_date'])
                                ->where('end_date', '>=', $data['end_date']);
                          });
                })->exists();

            if ($overlap) {
                throw new \Exception("Leave request overlaps with an existing request.");
            }

            // 2. Balance validation
            $usedDays = LeaveRequest::where('employee_id', $employee->id)
                ->where('leave_type_id', $leaveType->id)
                ->whereIn('status', ['submitted', 'manager_approved', 'hr_approved'])
                ->whereYear('start_date', now()->year)
                ->sum('days_requested');

            if (($usedDays + $data['days_requested']) > $leaveType->allowance_days) {
                throw new \Exception("Insufficient leave balance. Remaining: " . ($leaveType->allowance_days - $usedDays));
            }

            $leaveRequest = LeaveRequest::create($data);
            $leaveRequest->logStatusChange('submitted', null, ['remarks' => 'Initial submission']);

            return $leaveRequest;
        });
    }

    public function approveByManager(LeaveRequest $leaveRequest, int $userId)
    {
        $leaveRequest->approved_by_manager = $userId;
        $leaveRequest->logStatusChange('manager_approved', $leaveRequest->status);
    }

    public function approveByHR(LeaveRequest $leaveRequest, int $userId)
    {
        $leaveRequest->approved_by_hr = $userId;
        $leaveRequest->logStatusChange('hr_approved', $leaveRequest->status);
    }
}
