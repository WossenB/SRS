<?php

namespace App\Policies;

use App\Models\Timesheet;
use App\Models\User;

class TimesheetPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Timesheet $timesheet): bool
    {
        if ($user->hasAnyRole(['Super Admin', 'HR Admin'])) return true;
        if ($timesheet->employee->user_id === $user->id) return true;
        if ($timesheet->employee->supervisor_id === $user->employee?->id) return true;
        return false;
    }

    public function submit(User $user, Timesheet $timesheet): bool
    {
        return $timesheet->employee->user_id === $user->id && $timesheet->status === 'draft';
    }

    public function approve(User $user, Timesheet $timesheet): bool
    {
        return ($user->hasRole('Department Manager') && $timesheet->employee->supervisor_id === $user->employee?->id)
            || $user->hasRole('Super Admin');
    }
}
