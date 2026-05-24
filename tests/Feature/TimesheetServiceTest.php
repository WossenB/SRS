<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use App\Models\Timesheet;
use App\Models\TimesheetEntry;
use App\Services\TimesheetService;

class TimesheetServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_submit_empty_timesheet()
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

        $timesheet = Timesheet::create([
            'employee_id' => $employee->id,
            'start_date' => '2024-06-01',
            'end_date' => '2024-06-07',
            'status' => 'draft',
        ]);

        $service = new TimesheetService();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Cannot submit an empty timesheet.");

        $service->submitTimesheet($timesheet);
    }

    public function test_can_submit_timesheet_with_entries()
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

        $timesheet = Timesheet::create([
            'employee_id' => $employee->id,
            'start_date' => '2024-06-01',
            'end_date' => '2024-06-07',
            'status' => 'draft',
        ]);

        TimesheetEntry::create([
            'timesheet_id' => $timesheet->id,
            'date' => '2024-06-01',
            'hours' => 8,
            'type' => 'regular',
        ]);

        $service = new TimesheetService();
        $service->submitTimesheet($timesheet);

        $this->assertEquals('submitted', $timesheet->fresh()->status);
    }
}
