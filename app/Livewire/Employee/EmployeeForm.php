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
    public $step = 1;
    public $employeeId;

    // Step 1: Personal
    public $first_name, $last_name, $email, $employee_id_number, $date_of_birth, $phone;

    // Step 2: Job
    public $department_id, $position_id, $hire_date, $supervisor_id;

    // Step 3: Financial
    public $basic_salary, $tin_number, $bank_details;

    public function nextStep() { $this->step++; }
    public function prevStep() { $this->step--; }

    public function save()
    {
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'basic_salary' => 'required|numeric',
        ]);

        DB::transaction(function () {
            $user = User::updateOrCreate(['email' => $this->email], [
                'name' => "{$this->first_name} {$this->last_name}",
                'password' => Hash::make(\Illuminate\Support\Str::random(16)),
            ]);

            if (!$user->hasRole('Employee')) $user->assignRole('Employee');

            Employee::updateOrCreate(['user_id' => $user->id], [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'employee_id' => $this->employee_id_number ?? 'EMP-' . uniqid(),
                'phone' => $this->phone,
                'basic_salary' => $this->basic_salary,
                'department_id' => $this->department_id,
                'position_id' => $this->position_id,
                'hire_date' => $this->hire_date,
                'date_of_birth' => $this->date_of_birth,
                'tin_number' => $this->tin_number,
                'bank_details' => $this->bank_details,
            ]);
        });

        return redirect()->route('employees.index');
    }

    public function render()
    {
        return view('livewire.employee.employee-form', [
            'departments' => Department::all(),
            'positions' => Position::all(),
            'employees' => Employee::all(),
        ])->layout('layouts.app');
    }
}
