<?php

namespace App\Policies;

use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LeaveRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, LeaveRequest $leaveRequest): bool
    {
        if ($user->hasAnyRole(['Super Admin', 'HR Admin'])) return true;
        if ($leaveRequest->employee->user_id === $user->id) return true;
        if ($leaveRequest->employee->supervisor_id === $user->employee?->id) return true;
        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('leave.request');
    }

    public function update(User $user, LeaveRequest $leaveRequest): bool
    {
        if ($leaveRequest->status !== 'submitted' && $leaveRequest->status !== 'draft') return false;
        return $leaveRequest->employee->user_id === $user->id;
    }

    public function approve(User $user, LeaveRequest $leaveRequest): bool
    {
        if ($user->hasRole('Department Manager') && $leaveRequest->employee->supervisor_id === $user->employee?->id) {
            return $user->hasPermissionTo('leave.approve_manager');
        }
        if ($user->hasRole('HR Admin')) {
            return $user->hasPermissionTo('leave.approve_hr');
        }
        return $user->hasRole('Super Admin');
    }
}
