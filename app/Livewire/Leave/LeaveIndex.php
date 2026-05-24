<?php

namespace App\Livewire\Leave;

use Livewire\Component;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;

class LeaveIndex extends Component
{
    public function render()
    {
        $requests = LeaveRequest::where('employee_id', Auth::user()->employee?->id)
            ->with('leaveType')
            ->latest()
            ->get();

        return view('livewire.leave.leave-index', [
            'requests' => $requests
        ])->layout('layouts.app');
    }
}
