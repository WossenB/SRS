<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\PayrollRun;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $stats = [];

    public function mount()
    {
        $user = Auth::user();

        if ($user->hasRole('Super Admin') || $user->hasRole('HR Admin')) {
            $this->stats = [
                'total_employees' => Employee::count(),
                'pending_leave' => LeaveRequest::where('status', 'submitted')->count(),
                'last_payroll' => PayrollRun::latest()->first()?->total_net ?? 0,
            ];
        } else {
            $this->stats = [
                'my_leave_balance' => 20, // Sample
                'pending_requests' => LeaveRequest::where('employee_id', $user->employee?->id)->where('status', 'submitted')->count(),
            ];
        }
    }

    public function render()
    {
        return view('livewire.dashboard')->layout('layouts.app');
    }
}
