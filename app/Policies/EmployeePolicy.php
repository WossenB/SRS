<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EmployeePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Super Admin', 'HR Admin', 'HR Officer']);
    }

    public function view(User $user, Employee $employee): bool
    {
        if ($user->hasAnyRole(['Super Admin', 'HR Admin', 'HR Officer'])) return true;
        if ($employee->user_id === $user->id) return true;
        if ($employee->supervisor_id === $user->employee?->id) return true;
        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['Super Admin', 'HR Admin', 'HR Officer']);
    }

    public function update(User $user, Employee $employee): bool
    {
        return $user->hasAnyRole(['Super Admin', 'HR Admin']);
    }

    public function delete(User $user, Employee $employee): bool
    {
        return $user->hasRole('Super Admin');
    }
}
