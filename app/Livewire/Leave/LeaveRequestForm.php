<?php

namespace App\Livewire\Leave;

use Livewire\Component;
use App\Models\LeaveType;
use App\Services\LeaveService;
use Illuminate\Support\Facades\Auth;

class LeaveRequestForm extends Component
{
    public $leave_type_id;
    public $start_date;
    public $end_date;
    public $days_requested = 0;
    public $reason;
    public $error = '';

    protected $rules = [
        'leave_type_id' => 'required|exists:leave_types,id',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'required|string|min:10',
    ];

    public function updated($field)
    {
        if (in_array($field, ['start_date', 'end_date'])) {
            $this->calculateDays();
        }
    }

    private function calculateDays()
    {
        if ($this->start_date && $this->end_date) {
            $start = \Carbon\Carbon::parse($this->start_date);
            $end = \Carbon\Carbon::parse($this->end_date);
            $this->days_requested = max(0, $end->diffInDays($start) + 1);
        }
    }

    public function submit()
    {
        $this->validate();

        try {
            $service = new LeaveService();
            $service->submitRequest([
                'employee_id' => Auth::user()->employee->id,
                'leave_type_id' => $this->leave_type_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'days_requested' => $this->days_requested,
                'reason' => $this->reason,
            ]);

            session()->flash('success', 'Leave request submitted successfully!');
            return redirect()->route('leave.index');
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.leave.leave-request-form', [
            'leaveTypes' => LeaveType::all()
        ])->layout('layouts.app');
    }
}
