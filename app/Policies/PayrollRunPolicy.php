<?php

namespace App\Policies;

use App\Models\PayrollRun;
use App\Models\User;

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

    public function initiate(User $user): bool
    {
        return $user->hasPermissionTo('payroll.initiate');
    }

    public function approve(User $user, PayrollRun $payrollRun): bool
    {
        return $user->hasPermissionTo('payroll.approve');
    }
}
