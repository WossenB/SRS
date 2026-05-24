<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use App\Services\LeaveService;

class LeaveServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_submit_overlapping_leave()
    {
        $user = User::factory()->create();
        $dept = Department::create(['name' => 'IT']);
        $pos = Position::create(['title' => 'Dev']);

        $employee = Employee::create([
            'user_id' => $user->id,
            'employee_id' => 'EMP001',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'date_of_birth' => '1990-01-01',
            'hire_date' => '2020-01-01',
            'department_id' => $dept->id,
            'position_id' => $pos->id,
            'basic_salary' => '10000',
        ]);

        $leaveType = LeaveType::create([
            'name' => 'Annual',
            'allowance_days' => 20,
        ]);

        $service = new LeaveService();

        $service->submitRequest([
            'employee_id' => $employee->id,
            'leave_type_id' => $leaveType->id,
            'start_date' => '2024-06-01',
            'end_date' => '2024-06-05',
            'days_requested' => 5,
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Leave request overlaps with an existing request.");

        $service->submitRequest([
            'employee_id' => $employee->id,
            'leave_type_id' => $leaveType->id,
            'start_date' => '2024-06-03',
            'end_date' => '2024-06-07',
            'days_requested' => 5,
        ]);
    }
}
