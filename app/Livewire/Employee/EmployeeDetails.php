<?php

namespace App\Livewire\Employee;

use Livewire\Component;
use App\Models\Employee;

class EmployeeDetails extends Component
{
    public $employee;

    public function mount(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function render()
    {
        return view('livewire.employee.employee-details')->layout('layouts.app');
    }
}
