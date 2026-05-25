<?php

namespace App\Livewire\ESS;

use Livewire\Component;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class PersonalProfile extends Component
{
    public $employee;
    public $address, $phone;

    public function mount()
    {
        $this->employee = Auth::user()->employee;
        $this->address = $this->employee?->address;
        $this->phone = $this->employee?->phone;
    }

    public function requestUpdate()
    {
        // SRS: ESS can request personal info updates.
        // Logic: Log into employee_history or audit_logs as a request
        session()->flash('message', 'Update request sent to HR.');
    }

    public function render()
    {
        return view('livewire.ess.personal-profile')->layout('layouts.app');
    }
}
