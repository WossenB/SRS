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
        $employees = Employee::where('first_name', 'like', '%' . $this->search . '%')
            ->orWhere('last_name', 'like', '%' . $this->search . '%')
            ->orWhere('employee_id', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.employee-list', [
            'employees' => $employees
        ])->layout('layouts.app');
    }
}
