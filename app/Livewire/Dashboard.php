<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\PayrollRun;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Dashboard extends Component
{
    public $stats = [];
    public $chartData = [];

    public function mount()
    {
        $user = Auth::user();

        // SRS: Performance Targets - Dashboard < 3s. Cache KPIs for 5 mins.
        $this->stats = Cache::remember("dashboard_stats_{$user->id}", 300, function () use ($user) {
            if ($user->hasAnyRole(['Super Admin', 'HR Admin'])) {
                return [
                    'total_employees' => Employee::count(),
                    'pending_leave' => LeaveRequest::where('status', 'submitted')->count(),
                    'last_payroll' => PayrollRun::latest()->first()?->total_net ?? 0,
                ];
            } else {
                return [
                    'my_leave_balance' => 20,
                    'pending_requests' => LeaveRequest::where('employee_id', $user->employee?->id)->where('status', 'submitted')->count(),
                ];
            }
        });

        if ($user->hasAnyRole(['Super Admin', 'HR Admin'])) {
            $this->chartData['dept'] = Cache::remember("dashboard_chart_dept", 300, function () {
                return Department::withCount('employees')->get()->pluck('employees_count', 'name')->toArray();
            });
        }
    }

    public function render()
    {
        return view('livewire.dashboard')->layout('layouts.app');
    }
}
