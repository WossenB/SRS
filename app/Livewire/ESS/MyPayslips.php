<?php

namespace App\Livewire\ESS;

use Livewire\Component;
use App\Models\PayrollItem;
use Illuminate\Support\Facades\Auth;

class MyPayslips extends Component
{
    public function render()
    {
        $employee = Auth::user()->employee;

        $payslips = $employee ? PayrollItem::where('employee_id', $employee->id)
            ->with('payrollRun')
            ->whereHas('payrollRun', function($q) {
                $q->where('status', 'locked');
            })
            ->latest()
            ->get() : collect();

        return view('livewire.ess.my-payslips', [
            'payslips' => $payslips
        ])->layout('layouts.app');
    }
}
