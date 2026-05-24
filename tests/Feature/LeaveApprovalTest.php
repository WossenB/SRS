<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use Spatie\Permission\Models\Role;

class LeaveApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_approve_leave()
    {
        Role::create(['name' => 'Department Manager']);
        $dept = Department::create(['name' => 'IT']);
        $pos = Position::create(['title' => 'Dev']);

        $employeeUser = User::factory()->create();
        $employee = Employee::create([
            'user_id' => $employeeUser->id,
            'employee_id' => 'EMP001',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@test.com',
            'date_of_birth' => '1990-01-01',
            'hire_date' => '2020-01-01',
            'department_id' => $dept->id,
            'position_id' => $pos->id,
            'basic_salary' => '5000',
        ]);

        $managerUser = User::factory()->create();
        $managerUser->assignRole('Department Manager');
        $manager = Employee::create([
            'user_id' => $managerUser->id,
            'employee_id' => 'MGR001',
            'first_name' => 'Manager',
            'last_name' => 'One',
            'email' => 'mgr@test.com',
            'date_of_birth' => '1980-01-01',
            'hire_date' => '2010-01-01',
            'department_id' => $dept->id,
            'position_id' => $pos->id,
            'basic_salary' => '10000',
        ]);

        $employee->update(['supervisor_id' => $manager->id]);

        $leaveType = LeaveType::create(['name' => 'Annual', 'allowance_days' => 20]);

        $leave = LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type_id' => $leaveType->id,
            'start_date' => '2024-06-01',
            'end_date' => '2024-06-05',
            'days_requested' => 5,
            'status' => 'submitted',
        ]);

        $this->actingAs($managerUser);

        // Simulating the Livewire action directly via service call for simplicity in this test
        $service = new \App\Services\LeaveService();
        $service->approveByManager($leave, $managerUser->id);

        $leave->refresh();
        $this->assertEquals('manager_approved', $leave->status);
    }
}
