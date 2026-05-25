<?php

namespace App\Livewire\Offboarding;

use Livewire\Component;
use App\Models\Employee;
use App\Services\OffboardingService;

class OffboardingForm extends Component
{
    public $employeeId;
    public $separation_date, $exit_type, $reason;

    public function mount($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    public function initiate()
    {
        $this->validate([
            'separation_date' => 'required|date',
            'exit_type' => 'required',
        ]);

        $service = new OffboardingService();
        $service->initiateExit($this->employeeId, [
            'separation_date' => $this->separation_date,
            'exit_type' => $this->exit_type,
            'reason' => $this->reason,
        ]);

        return redirect()->route('offboarding.index');
    }

    public function render()
    {
        return view('livewire.offboarding.offboarding-form', [
            'employee' => Employee::findOrFail($this->employeeId)
        ])->layout('layouts.app');
    }
}
