<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use Livewire\WithPagination;

class EmployeeList extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        // SRS: Performance optimization for 500+ employees
        $employees = Employee::where('first_name', 'like', '%' . $this->search . '%')
            ->orWhere('last_name', 'like', '%' . $this->search . '%')
            ->orWhere('employee_id', 'like', '%' . $this->search . '%')
            ->orderBy('id')
            ->cursorPaginate(15);

        return view('livewire.employee-list', [
            'employees' => $employees
        ])->layout('layouts.app');
    }
}
