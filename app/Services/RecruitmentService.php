<?php

namespace App\Services;

use App\Models\Applicant;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RecruitmentService
{
    /**
     * Convert a hired applicant into an employee.
     * SRS Ref: FR-REC-06
     */
    public function convertToEmployee(Applicant $applicant, array $hiringData)
    {
        return DB::transaction(function () use ($applicant, $hiringData) {
            $applicant->update(['status' => 'hired']);

            $user = User::create([
                'name' => "{$applicant->first_name} {$applicant->last_name}",
                'email' => $applicant->email,
                'password' => Hash::make(Str::random(12)), // System generated
            ]);
            $user->assignRole('Employee');

            $employee = Employee::create([
                'user_id' => $user->id,
                'employee_id' => $hiringData['employee_id'],
                'first_name' => $applicant->first_name,
                'last_name' => $applicant->last_name,
                'email' => $applicant->email,
                'phone' => $applicant->phone,
                'hire_date' => $hiringData['hire_date'],
                'department_id' => $hiringData['department_id'],
                'position_id' => $hiringData['position_id'],
                'basic_salary' => $hiringData['basic_salary'],
                'status' => 'active',
                'date_of_birth' => $hiringData['date_of_birth'] ?? now()->subYears(20),
            ]);

            return $employee;
        });
    }
}
