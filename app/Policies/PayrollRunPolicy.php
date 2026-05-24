<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PayrollRun;

class PayrollRunPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Super Admin', 'HR Admin']);
    }

    public function view(User $user, PayrollRun $payrollRun): bool
    {
        return $user->hasAnyRole(['Super Admin', 'HR Admin']);
    }

    public function update(User $user, PayrollRun $payrollRun)
    {
        // Only HR Admin or Super Admin can update
        if (!$user->hasAnyRole(['HR Admin', 'Super Admin'])) {
            return false;
        }

        // Cannot edit locked payroll runs
        if ($payrollRun->status === 'locked') {
            return false;
        }

        return true;
    }

    public function lock(User $user, PayrollRun $payrollRun)
    {
        return $user->hasAnyRole(['HR Admin', 'Super Admin']);
    }

    public function delete(User $user, PayrollRun $payrollRun)
    {
        return false; // Never allow deletion
    }
}
