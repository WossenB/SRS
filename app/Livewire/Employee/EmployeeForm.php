<?php

namespace App\Livewire\Employee;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeForm extends Component
{
    public $employeeId;
    public $first_name, $last_name, $email, $employee_id_number, $basic_salary;
    public $department_id, $position_id, $hire_date, $date_of_birth;

    public function mount($id = null)
    {
        if ($id) {
            $employee = Employee::findOrFail($id);
            $this->employeeId = $id;
            $this->first_name = $employee->first_name;
            $this->last_name = $employee->last_name;
            $this->email = $employee->email;
            $this->employee_id_number = $employee->employee_id;
            $this->basic_salary = $employee->basic_salary;
            $this->department_id = $employee->department_id;
            $this->position_id = $employee->position_id;
            $this->hire_date = $employee->hire_date?->format('Y-m-d');
            $this->date_of_birth = $employee->date_of_birth?->format('Y-m-d');
        }
    }

    public function save()
    {
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'employee_id_number' => 'required',
            'basic_salary' => 'required|numeric',
        ]);

        DB::transaction(function () {
            if ($this->employeeId) {
                $employee = Employee::findOrFail($this->employeeId);
                $employee->update([
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'email' => $this->email,
                    'employee_id' => $this->employee_id_number,
                    'basic_salary' => $this->basic_salary,
                    'department_id' => $this->department_id,
                    'position_id' => $this->position_id,
                    'hire_date' => $this->hire_date,
                    'date_of_birth' => $this->date_of_birth,
                ]);
            } else {
                $user = User::create([
                    'name' => "{$this->first_name} {$this->last_name}",
                    'email' => $this->email,
                    'password' => Hash::make('password123'),
                ]);
                $user->assignRole('Employee');

                Employee::create([
                    'user_id' => $user->id,
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'email' => $this->email,
                    'employee_id' => $this->employee_id_number,
                    'basic_salary' => $this->basic_salary,
                    'department_id' => $this->department_id,
                    'position_id' => $this->position_id,
                    'hire_date' => $this->hire_date,
                    'date_of_birth' => $this->date_of_birth,
                ]);
            }
        });

        return redirect()->route('employees.index');
    }

    public function render()
    {
        return view('livewire.employee.employee-form', [
            'departments' => Department::all(),
            'positions' => Position::all(),
        ])->layout('layouts.app');
    }
}
