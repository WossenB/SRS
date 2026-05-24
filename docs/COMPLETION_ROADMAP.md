# 🛣️ SRS COMPLETION ROADMAP

**Last Updated:** 2026-05-24  
**Current Status:** 70% Complete  
**Estimated Completion Time:** 8-11 weeks  

---

## 📋 TABLE OF CONTENTS

1. [Critical Fixes (MUST DO)](#-critical-fixes-must-do) - 2-3 weeks
2. [High Priority (SHOULD DO)](#-high-priority-should-do) - 4-5 weeks
3. [Nice-to-Have (COULD DO)](#-nice-to-have-could-do) - Post-launch
4. [Testing & Documentation](#-testing--documentation) - 2-3 weeks
5. [Task List by Module](#-task-list-by-module)

---

## 🔴 CRITICAL FIXES (MUST DO)

### Priority: 2-3 weeks | Blocking: Production Deployment

---

#### 1. SESSION TIMEOUT & IDLE DETECTION (30 mins)

**Status:** ❌ Missing  
**Requirement:** FR-AUTH-01, 3.2  
**Files to Create/Modify:** 3  
**Effort:** 4-6 hours

##### 1.1 Create Session Timeout Middleware

```bash
php artisan make:middleware IdleSessionTimeout
```

**File:** `app/Http/Middleware/IdleSessionTimeout.php`

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdleSessionTimeout
{
    public function handle(Request $request, Closure $next)
    {
        $timeout = config('session.timeout_minutes', 30);
        $lastActivity = session('last_activity');

        if ($lastActivity && now()->diffInMinutes($lastActivity) > $timeout) {
            Auth::logout();
            session()->flush();
            
            return redirect()->route('login')
                ->with('message', 'Session expired due to inactivity. Please log in again.');
        }

        session(['last_activity' => now()]);
        return $next($request);
    }
}
```

##### 1.2 Register Middleware

**File:** `app/Http/Kernel.php`

```php
protected $middleware = [
    // ... existing
    \App\Http\Middleware\IdleSessionTimeout::class,
];
```

##### 1.3 Create Session Configuration

**File:** `config/session.php` (add to file)

```php
'timeout_minutes' => env('SESSION_TIMEOUT_MINUTES', 30),
```

**File:** `.env`

```env
SESSION_TIMEOUT_MINUTES=30
```

##### 1.4 Test Case

**File:** `tests/Feature/SessionTimeoutTest.php`

```php
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class SessionTimeoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_session_times_out_after_30_minutes()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Simulate 31 minutes passing
        session(['last_activity' => now()->subMinutes(31)]);

        $response = $this->get('/dashboard');

        $this->assertFalse(auth()->check());
        $response->assertRedirect(route('login'));
    }

    public function test_session_resets_on_activity()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        session(['last_activity' => now()->subMinutes(15)]);

        $this->get('/dashboard');

        $this->assertTrue(auth()->check());
        $this->assertTrue(session('last_activity')->diffInMinutes(now()) < 1);
    }
}
```

---

#### 2. PAYROLL LOCK ENFORCEMENT & APPLICATION GUARD

**Status:** ⚠️ Partially Done (status field exists, guard missing)  
**Requirement:** FR-PAY-06, 6.2  
**Files to Create/Modify:** 2  
**Effort:** 3-4 hours

##### 2.1 Create Policy Guard

**File:** `app/Policies/PayrollRunPolicy.php`

```php
<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PayrollRun;

class PayrollRunPolicy
{
    public function update(User $user, PayrollRun $payrollRun)
    {
        // Only HR Admin or Super Admin can update
        if (!$user->hasAnyRole(['HR Admin', 'Super Admin'])) {
            return false;
        }

        // Cannot edit locked payroll runs
        if ($payrollRun->status === 'locked') {
            throw new \Exception('Cannot edit locked payroll runs. Contact administrator.');
        }

        return true;
    }

    public function lock(User $user, PayrollRun $payrollRun)
    {
        return $user->hasAnyRole(['HR Admin', 'Super Admin']);
    }

    public function delete(User $user, PayrollRun $payrollRun)
    {
        return false; // Never allow deletion
    }
}
```

##### 2.2 Register Policy

**File:** `app/Providers/AuthServiceProvider.php`

```php
use App\Models\PayrollRun;
use App\Policies\PayrollRunPolicy;

public function boot()
{
    $this->registerPolicies();
    
    Gate::policy(PayrollRun::class, PayrollRunPolicy::class);
}
```

##### 2.3 Update PayrollService

**File:** `app/Services/PayrollService.php` (add method)

```php
public function lockPayrollRun(PayrollRun $payrollRun, int $userId)
{
    return DB::transaction(function () use ($payrollRun, $userId) {
        $payrollRun->status = 'locked';
        $payrollRun->approved_by = $userId;
        $payrollRun->approved_at = now();
        $payrollRun->save();

        $payrollRun->logStatusChange('locked', 'draft', [
            'approved_by' => $userId,
            'action' => 'Final approval'
        ]);

        // Prevent any further edits
        DB::statement(
            "UPDATE payroll_runs SET locked_at = ? WHERE id = ?",
            [now(), $payrollRun->id]
        );

        return $payrollRun;
    });
}
```

##### 2.4 Test

**File:** `tests/Feature/PayrollLockTest.php`

```php
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\PayrollRun;
use App\Models\User;

class PayrollLockTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_edit_locked_payroll()
    {
        $payroll = PayrollRun::factory()->create(['status' => 'locked']);

        $this->expectException(\Exception::class);
        $payroll->update(['total_net' => 99999]);
    }

    public function test_hr_can_lock_payroll()
    {
        $admin = User::factory()->create();
        $admin->assignRole('HR Admin');

        $payroll = PayrollRun::factory()->create(['status' => 'draft']);

        $this->assertTrue($admin->can('lock', $payroll));
    }

    public function test_employee_cannot_lock_payroll()
    {
        $emp = User::factory()->create();
        $emp->assignRole('Employee');

        $payroll = PayrollRun::factory()->create();

        $this->assertFalse($emp->can('lock', $payroll));
    }
}
```

---

#### 3. RATE LIMITING ON AUTH ENDPOINTS

**Status:** ❌ Missing  
**Requirement:** FR-AUTH-02, 3.2  
**Files to Create/Modify:** 2  
**Effort:** 2-3 hours

##### 3.1 Create Rate Limit Middleware

**File:** `app/Http/Middleware/RateLimitAuth.php`

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;

class RateLimitAuth extends ThrottleRequests
{
    public function handle($request, Closure $next, ...$limits)
    {
        // 5 attempts per minute for login
        if ($request->is('login') && $request->isMethod('post')) {
            return $this->handleRequest($request, $next, ['5,1']);
        }

        // 3 attempts per hour for password reset
        if ($request->is('password/email') && $request->isMethod('post')) {
            return $this->handleRequest($request, $next, ['3,60']);
        }

        return $next($request);
    }

    protected function handleRequest(Request $request, Closure $next, array $limits)
    {
        foreach ($limits as $limit) {
            if ($this->limiter->tooManyAttempts($this->resolveRequestSignature($request), $limit)) {
                return $this->buildException($request, $this->limiter->availableIn(
                    $this->resolveRequestSignature($request)
                ));
            }

            $this->limiter->hit($this->resolveRequestSignature($request), $limit);
        }

        return $next($request);
    }
}
```

##### 3.2 Apply to Routes

**File:** `routes/web.php` (update auth routes)

```php
Route::post('/login', [\Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'store'])
    ->middleware('rate.limit.auth')
    ->name('login.post');

Route::post('/password/email', [\Laravel\Fortify\Http\Controllers\PasswordResetLinkController::class, 'store'])
    ->middleware('rate.limit.auth')
    ->name('password.email.post');
```

##### 3.3 Test

**File:** `tests/Feature/RateLimitingTest.php`

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;

class RateLimitingTest extends TestCase
{
    public function test_login_rate_limited_after_5_attempts()
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email' => 'test@test.com', 'password' => 'wrong']);
        }

        $response = $this->post('/login', ['email' => 'test@test.com', 'password' => 'wrong']);
        $response->assertStatus(429); // Too Many Requests
    }

    public function test_password_reset_limited_to_3_per_hour()
    {
        for ($i = 0; $i < 3; $i++) {
            $this->post('/password/email', ['email' => 'test@test.com']);
        }

        $response = $this->post('/password/email', ['email' => 'test@test.com']);
        $response->assertStatus(429);
    }
}
```

---

#### 4. COMPLETE LEAVE APPROVAL WORKFLOW

**Status:** ⚠️ Partially Done (service exists, UI missing)  
**Requirement:** FR-LEAVE-01 to 05  
**Files to Create/Modify:** 5-6  
**Effort:** 8-10 hours

##### 4.1 Create Leave Request Livewire Component

**File:** `app/Livewire/Leave/LeaveRequestForm.php`

```php
<?php

namespace App\Livewire\Leave;

use Livewire\Component;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Employee;
use App\Services\LeaveService;

class LeaveRequestForm extends Component
{
    public $employee_id;
    public $leave_type_id;
    public $start_date;
    public $end_date;
    public $days_requested = 0;
    public $reason;
    public $leaveTypes;
    public $error = '';

    protected $rules = [
        'employee_id' => 'required|exists:employees,id',
        'leave_type_id' => 'required|exists:leave_types,id',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'required|string|min:10',
    ];

    public function mount()
    {
        $this->leaveTypes = LeaveType::all();
        $user = auth()->user();
        if ($user->employee) {
            $this->employee_id = $user->employee->id;
        }
    }

    public function updated($field)
    {
        if (in_array($field, ['start_date', 'end_date'])) {
            $this->calculateDays();
        }
    }

    private function calculateDays()
    {
        if ($this->start_date && $this->end_date) {
            $start = \Carbon\Carbon::parse($this->start_date);
            $end = \Carbon\Carbon::parse($this->end_date);
            $this->days_requested = max(0, $end->diffInDays($start) + 1);
        }
    }

    public function submit()
    {
        $this->validate();

        try {
            $service = new LeaveService();
            $service->submitRequest([
                'employee_id' => $this->employee_id,
                'leave_type_id' => $this->leave_type_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'days_requested' => $this->days_requested,
                'reason' => $this->reason,
                'status' => 'submitted',
            ]);

            session()->flash('success', 'Leave request submitted successfully!');
            $this->reset();
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.leave.leave-request-form');
    }
}
```

##### 4.2 Create View

**File:** `resources/views/livewire/leave/leave-request-form.blade.php`

```blade
<div class="max-w-2xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Submit Leave Request</h2>

    @if ($error)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ $error }}
        </div>
    @endif

    <form wire:submit="submit" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Leave Type</label>
            <select wire:model="leave_type_id" class="mt-1 block w-full rounded-md border">
                <option value="">-- Select --</option>
                @foreach ($leaveTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }} ({{ $type->allowance_days }} days)</option>
                @endforeach
            </select>
            @error('leave_type_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Start Date</label>
                <input type="date" wire:model="start_date" class="mt-1 block w-full rounded-md border" />
                @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">End Date</label>
                <input type="date" wire:model="end_date" class="mt-1 block w-full rounded-md border" />
                @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium">Days Requested</label>
            <input type="number" wire:model="days_requested" readonly class="mt-1 block w-full rounded-md border bg-gray-100" />
        </div>

        <div>
            <label class="block text-sm font-medium">Reason</label>
            <textarea wire:model="reason" rows="4" class="mt-1 block w-full rounded-md border"></textarea>
            @error('reason') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Submit Request
        </button>
    </form>
</div>
```

##### 4.3 Create Manager Approval Component

**File:** `app/Livewire/Leave/LeaveApprovalManager.php`

```php
<?php

namespace App\Livewire\Leave;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LeaveRequest;
use App\Services\LeaveService;

class LeaveApprovalManager extends Component
{
    use WithPagination;

    public $pendingLeaves;
    public $approvalComment = '';

    public function mount()
    {
        $user = auth()->user();
        $managedEmployeeIds = $user->managedEmployees()->pluck('id');

        $this->pendingLeaves = LeaveRequest::whereIn('employee_id', $managedEmployeeIds)
            ->where('status', 'submitted')
            ->with('employee', 'leaveType')
            ->paginate(10);
    }

    public function approve(LeaveRequest $leave)
    {
        if (!auth()->user()->can('leave.approve_manager')) {
            $this->addError('approval', 'Unauthorized');
            return;
        }

        $service = new LeaveService();
        $service->approveByManager($leave, auth()->id());

        $this->dispatch('approved', leaveId: $leave->id);
        session()->flash('success', 'Leave request approved!');
    }

    public function reject(LeaveRequest $leave)
    {
        if (!auth()->user()->can('leave.approve_manager')) {
            $this->addError('rejection', 'Unauthorized');
            return;
        }

        $leave->status = 'manager_rejected';
        $leave->save();
        $leave->logStatusChange('manager_rejected', 'submitted');

        session()->flash('success', 'Leave request rejected!');
    }

    public function render()
    {
        return view('livewire.leave.leave-approval-manager');
    }
}
```

##### 4.4 Create Route

**File:** `routes/web.php` (add)

```php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/leave/my-requests', \App\Livewire\Leave\LeaveRequestForm::class)->name('leave.requests');
    Route::get('/leave/approvals', \App\Livewire\Leave\LeaveApprovalManager::class)
        ->name('leave.approvals')
        ->middleware('can:leave.approve_manager');
});
```

##### 4.5 Create Tests

**File:** `tests/Feature/LeaveApprovalTest.php`

```php
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

class LeaveApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_approve_leave()
    {
        $dept = Department::create(['name' => 'IT']);
        $pos = Position::create(['title' => 'Dev']);

        $employee = Employee::create([
            'user_id' => User::factory()->create()->id,
            'employee_id' => 'EMP001',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@test.com',
            'date_of_birth' => '1990-01-01',
            'hire_date' => '2020-01-01',
            'department_id' => $dept->id,
            'position_id' => $pos->id,
        ]);

        $manager = User::factory()->create();
        $manager->assignRole('Department Manager');

        $leaveType = LeaveType::create(['name' => 'Annual', 'allowance_days' => 20]);

        $leave = LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type_id' => $leaveType->id,
            'start_date' => '2024-06-01',
            'end_date' => '2024-06-05',
            'days_requested' => 5,
            'reason' => 'Vacation',
            'status' => 'submitted',
        ]);

        $this->actingAs($manager);
        $response = $this->post("/leave/{$leave->id}/approve");

        $leave->refresh();
        $this->assertEquals('manager_approved', $leave->status);
    }

    public function test_employee_cannot_approve_own_leave()
    {
        $user = User::factory()->create();
        $user->assignRole('Employee');

        $employee = Employee::factory()->create(['user_id' => $user->id]);
        $leaveType = LeaveType::factory()->create();
        $leave = LeaveRequest::factory()->create(['employee_id' => $employee->id]);

        $this->actingAs($user)
            ->post("/leave/{$leave->id}/approve")
            ->assertForbidden();
    }
}
```

---

#### 5. COMPLETE TIMESHEET WORKFLOW

**Status:** ⚠️ Minimal (Service is 1.3 KB, UI missing)  
**Requirement:** FR-TIME-01 to 05, 6.1  
**Files to Create/Modify:** 6-8  
**Effort:** 12-15 hours

##### 5.1 Enhance TimesheetService

**File:** `app/Services/TimesheetService.php` (replace)

```php
<?php

namespace App\Services;

use App\Models\Timesheet;
use App\Models\TimesheetEntry;
use App\Models\Employee;
use App\Models\WorkSchedule;
use Illuminate\Support\Facades\DB;

class TimesheetService
{
    /**
     * Create timesheet for employee for given week
     * SRS Ref: FR-TIME-01
     */
    public function createWeeklyTimesheet(Employee $employee, \Carbon\Carbon $weekStart)
    {
        return DB::transaction(function () use ($employee, $weekStart) {
            // Check if already exists
            $existing = Timesheet::where('employee_id', $employee->id)
                ->where('week_start', $weekStart)
                ->first();

            if ($existing) {
                return $existing;
            }

            $timesheet = Timesheet::create([
                'employee_id' => $employee->id,
                'week_start' => $weekStart,
                'week_end' => $weekStart->copy()->addDays(6),
                'status' => 'draft',
                'version' => 1,
            ]);

            // Pre-fill with work schedule
            $schedule = WorkSchedule::where('is_default', true)->first();
            $workingDays = $schedule->working_days_json ?? ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

            for ($i = 0; $i < 7; $i++) {
                $date = $weekStart->copy()->addDays($i);
                $dayName = $date->format('l'); // Full day name

                $hours = in_array($dayName, $workingDays) ? $schedule->standard_hours ?? 8 : 0;

                TimesheetEntry::create([
                    'timesheet_id' => $timesheet->id,
                    'date' => $date,
                    'day_of_week' => $dayName,
                    'hours_worked' => $hours,
                    'overtime_hours' => 0,
                    'is_working_day' => in_array($dayName, $workingDays),
                    'remarks' => null,
                ]);
            }

            return $timesheet;
        });
    }

    /**
     * Submit timesheet for approval
     * SRS Ref: FR-TIME-02
     */
    public function submitTimesheet(Timesheet $timesheet, array $entries)
    {
        return DB::transaction(function () use ($timesheet, $entries) {
            // Validate at least one entry submitted
            $hasEntries = count($entries) > 0;
            if (!$hasEntries) {
                throw new \Exception('Timesheet must have at least one entry.');
            }

            // Update entries
            foreach ($entries as $entryId => $data) {
                TimesheetEntry::find($entryId)->update([
                    'hours_worked' => $data['hours_worked'],
                    'overtime_hours' => $data['overtime_hours'] ?? 0,
                    'remarks' => $data['remarks'] ?? null,
                ]);
            }

            $timesheet->status = 'submitted';
            $timesheet->submitted_at = now();
            $timesheet->submitted_by = auth()->id();
            $timesheet->save();

            $timesheet->logStatusChange('submitted', 'draft', [
                'submitted_by' => auth()->id()
            ]);

            return $timesheet;
        });
    }

    /**
     * Approve timesheet by supervisor
     * SRS Ref: FR-TIME-03
     */
    public function approveBySupervisor(Timesheet $timesheet, ?string $comment = null)
    {
        return DB::transaction(function () use ($timesheet, $comment) {
            // Check for unapproved absences
            $absences = TimesheetEntry::where('timesheet_id', $timesheet->id)
                ->where('hours_worked', 0)
                ->where('is_working_day', true)
                ->get();

            if ($absences->count() > 0) {
                throw new \Exception('Cannot approve timesheet with unapproved absences. Review and mark as legitimate.');
            }

            $timesheet->status = 'supervisor_approved';
            $timesheet->supervisor_approved_by = auth()->id();
            $timesheet->supervisor_approved_at = now();
            $timesheet->save();

            $timesheet->logStatusChange('supervisor_approved', 'submitted', [
                'approved_by' => auth()->id(),
                'comment' => $comment
            ]);

            return $timesheet;
        });
    }

    /**
     * Return timesheet for correction
     * SRS Ref: FR-TIME-04
     */
    public function returnForCorrection(Timesheet $timesheet, string $reason)
    {
        if (!$reason || strlen($reason) < 10) {
            throw new \Exception('Correction reason must be at least 10 characters.');
        }

        $timesheet->status = 'returned';
        $timesheet->save();

        $timesheet->logStatusChange('returned', 'submitted', [
            'reason' => $reason,
            'returned_by' => auth()->id()
        ]);

        return $timesheet;
    }

    /**
     * Bulk approve timesheets for a week
     * SRS Ref: FR-TIME-05
     */
    public function bulkApproveWeek(\Carbon\Carbon $weekStart)
    {
        $timesheets = Timesheet::where('week_start', $weekStart)
            ->where('status', 'submitted')
            ->get();

        $count = 0;
        foreach ($timesheets as $timesheet) {
            try {
                $this->approveBySupervisor($timesheet);
                $count++;
            } catch (\Exception $e) {
                // Log but continue
                \Log::warning("Failed to approve timesheet {$timesheet->id}: " . $e->getMessage());
            }
        }

        return $count;
    }
}
```

##### 5.2 Create Timesheet Grid Component

**File:** `app/Livewire/Timesheet/TimesheetGrid.php`

```php
<?php

namespace App\Livewire\Timesheet;

use Livewire\Component;
use App\Models\Timesheet;
use App\Models\TimesheetEntry;
use App\Services\TimesheetService;

class TimesheetGrid extends Component
{
    public $timesheet;
    public $entries = [];
    public $weekStart;
    public $error = '';
    public $message = '';

    protected $rules = [
        'entries.*.hours_worked' => 'required|numeric|min:0|max:24',
        'entries.*.overtime_hours' => 'required|numeric|min:0|max:8',
    ];

    public function mount(Timesheet $timesheet)
    {
        $this->timesheet = $timesheet;
        $this->weekStart = $timesheet->week_start;

        $this->entries = $timesheet->entries->mapWithKeys(function ($entry) {
            return [
                $entry->id => [
                    'date' => $entry->date->format('Y-m-d'),
                    'day' => $entry->day_of_week,
                    'hours_worked' => $entry->hours_worked,
                    'overtime_hours' => $entry->overtime_hours,
                    'remarks' => $entry->remarks,
                    'is_working_day' => $entry->is_working_day,
                ]
            ];
        })->toArray();
    }

    public function submit()
    {
        try {
            $service = new TimesheetService();
            
            $entriesData = [];
            foreach ($this->entries as $entryId => $data) {
                $entriesData[$entryId] = [
                    'hours_worked' => $data['hours_worked'],
                    'overtime_hours' => $data['overtime_hours'],
                    'remarks' => $data['remarks'],
                ];
            }

            $service->submitTimesheet($this->timesheet, $entriesData);
            $this->message = 'Timesheet submitted for approval!';
            $this->redirect(route('timesheet.index'));
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.timesheet.timesheet-grid');
    }
}
```

##### 5.3 Create Timesheet Approval Component

**File:** `app/Livewire/Timesheet/TimesheetApproval.php`

```php
<?php

namespace App\Livewire\Timesheet;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Timesheet;
use App\Services\TimesheetService;

class TimesheetApproval extends Component
{
    use WithPagination;

    public $pendingTimesheets;
    public $selectedWeek;

    public function mount()
    {
        $this->pendingTimesheets = Timesheet::where('status', 'submitted')
            ->with('employee')
            ->paginate(10);
    }

    public function approve(Timesheet $timesheet)
    {
        try {
            $service = new TimesheetService();
            $service->approveBySupervisor($timesheet);
            $this->dispatch('approved');
            session()->flash('success', 'Timesheet approved!');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function return(Timesheet $timesheet, $reason)
    {
        try {
            $service = new TimesheetService();
            $service->returnForCorrection($timesheet, $reason);
            session()->flash('success', 'Timesheet returned for correction!');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function bulkApprove()
    {
        try {
            $service = new TimesheetService();
            $count = $service->bulkApproveWeek($this->selectedWeek);
            session()->flash('success', "Approved $count timesheets for the week!");
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.timesheet.timesheet-approval');
    }
}
```

##### 5.4 Create Views

**File:** `resources/views/livewire/timesheet/timesheet-grid.blade.php`

```blade
<div class="max-w-6xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Timesheet: {{ $weekStart->format('M d, Y') }} - {{ $weekStart->copy()->addDays(6)->format('M d, Y') }}</h2>

    @if ($error)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ $error }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Date</th>
                    <th class="border px-4 py-2">Day</th>
                    <th class="border px-4 py-2">Hours</th>
                    <th class="border px-4 py-2">Overtime</th>
                    <th class="border px-4 py-2">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entries as $id => $entry)
                    <tr class="{{ !$entry['is_working_day'] ? 'bg-gray-100' : '' }}">
                        <td class="border px-4 py-2">{{ $entry['date'] }}</td>
                        <td class="border px-4 py-2">{{ $entry['day'] }}</td>
                        <td class="border px-4 py-2">
                            <input type="number" wire:model="entries.{{ $id }}.hours_worked" 
                                {{ !$entry['is_working_day'] ? 'disabled' : '' }}
                                class="w-20 rounded border" />
                        </td>
                        <td class="border px-4 py-2">
                            <input type="number" wire:model="entries.{{ $id }}.overtime_hours" 
                                class="w-20 rounded border" />
                        </td>
                        <td class="border px-4 py-2">
                            <input type="text" wire:model="entries.{{ $id }}.remarks" 
                                class="w-full rounded border" placeholder="Optional note" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex gap-4">
        <button wire:click="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
            Submit for Approval
        </button>
        <a href="{{ route('timesheet.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
            Cancel
        </a>
    </div>
</div>
```

##### 5.5 Create Routes

**File:** `routes/web.php` (add)

```php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/timesheet', \App\Livewire\Timesheet\TimesheetIndex::class)->name('timesheet.index');
    Route::get('/timesheet/{timesheet}/edit', \App\Livewire\Timesheet\TimesheetGrid::class)->name('timesheet.edit');
    Route::get('/timesheet/approvals', \App\Livewire\Timesheet\TimesheetApproval::class)
        ->name('timesheet.approvals')
        ->middleware('can:timesheet.approve_supervisor');
});
```

##### 5.6 Tests

**File:** `tests/Feature/TimesheetWorkflowTest.php`

```php
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Timesheet;
use App\Models\TimesheetEntry;
use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use App\Services\TimesheetService;

class TimesheetWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_weekly_timesheet()
    {
        $dept = Department::create(['name' => 'IT']);
        $pos = Position::create(['title' => 'Dev']);
        $employee = Employee::create([
            'user_id' => User::factory()->create()->id,
            'employee_id' => 'EMP001',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@test.com',
            'date_of_birth' => '1990-01-01',
            'hire_date' => '2020-01-01',
            'department_id' => $dept->id,
            'position_id' => $pos->id,
        ]);

        $service = new TimesheetService();
        $weekStart = now()->startOfWeek();

        $timesheet = $service->createWeeklyTimesheet($employee, $weekStart);

        $this->assertEquals('draft', $timesheet->status);
        $this->assertEquals(7, $timesheet->entries->count());
    }

    public function test_cannot_submit_empty_timesheet()
    {
        $timesheet = Timesheet::factory()->create(['status' => 'draft']);

        $service = new TimesheetService();

        $this->expectException(\Exception::class);
        $service->submitTimesheet($timesheet, []);
    }

    public function test_approve_timesheet()
    {
        $timesheet = Timesheet::factory()->create(['status' => 'submitted']);
        TimesheetEntry::factory(5)->create(['timesheet_id' => $timesheet->id]);

        $service = new TimesheetService();
        $service->approveBySupervisor($timesheet);

        $timesheet->refresh();
        $this->assertEquals('supervisor_approved', $timesheet->status);
    }
}
```

---

## 🟡 HIGH PRIORITY (SHOULD DO)

### Priority: 4-5 weeks | Blocking: Full Feature Launch

---

#### 6. COMPLETE NOTIFICATIONS SYSTEM (Entire Module)

**Status:** ❌ Missing (Zero implementation)  
**Requirement:** FR-ANN-01 to 03, FR-NOTIF-01 to 03  
**Files to Create:** 10+  
**Effort:** 15-20 hours

> **How-to:** [Full implementation guide](./NOTIFICATION_SYSTEM_GUIDE.md)

**Summary:**
- Create `Announcement` model & migration
- Create `Notification` model with queue jobs
- Implement Livewire bell notification component
- Create email dispatch queue job
- Implement user preference toggles
- Set up event listeners for leave/payroll/etc approvals

---

#### 7. COMPLETE PAYROLL FEATURES

**Status:** ⚠️ 60% Done (Math works, PDF & exports missing)  
**Requirement:** FR-PAY-01 to 06, 6.2  
**Files to Create/Modify:** 5-6  
**Effort:** 10-12 hours

##### 7.1 Payslip PDF Generation

**File:** `app/Services/PayslipService.php`

```php
<?php

namespace App\Services;

use App\Models\PayrollItem;
use Barryvdh\DomPDF\Facade\Pdf;

class PayslipService
{
    public function generatePayslip(PayrollItem $item)
    {
        $data = [
            'employee' => $item->employee,
            'payroll' => $item->payrollRun,
            'item' => $item,
            'companyName' => config('app.company_name', 'Birrama Digital'),
        ];

        return Pdf::loadView('payslip', $data)
            ->setOption('enable-local-file-access', true)
            ->download("payslip_{$item->employee->employee_code}_{$item->payroll->period_month}.pdf");
    }

    public function generateBulkPayslips(int $payrollRunId)
    {
        $items = PayrollItem::where('payroll_run_id', $payrollRunId)->get();
        $zip = new \ZipArchive();
        $filename = "payslips_{$payrollRunId}.zip";

        if ($zip->open(storage_path($filename), \ZipArchive::CREATE) === true) {
            foreach ($items as $item) {
                $pdf = $this->generatePayslip($item);
                $zip->addFromString("payslip_{$item->employee->employee_code}.pdf", $pdf->output());
            }
            $zip->close();
        }

        return $filename;
    }
}
```

**File:** `resources/views/payslip.blade.php`

```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payslip</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .section { margin-bottom: 20px; border-top: 1px solid #ddd; padding-top: 10px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 8px; border-bottom: 1px solid #eee; }
        .label { font-weight: bold; width: 50%; }
        .amount { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $companyName }}</h1>
        <h2>PAYSLIP</h2>
        <p>Period: {{ $payroll->period_month }}</p>
    </div>

    <div class="section">
        <h3>Employee Information</h3>
        <table>
            <tr>
                <td class="label">Name:</td>
                <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
            </tr>
            <tr>
                <td class="label">Employee ID:</td>
                <td>{{ $employee->employee_code }}</td>
            </tr>
            <tr>
                <td class="label">Department:</td>
                <td>{{ $employee->department->name }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3>Salary Details</h3>
        <table>
            <tr>
                <td class="label">Basic Salary</td>
                <td class="amount">{{ number_format($item->basic_salary, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Gross Salary</td>
                <td class="amount">{{ number_format($item->gross_salary, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Taxable Income</td>
                <td class="amount">{{ number_format($item->taxable_income, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3>Deductions</h3>
        <table>
            <tr>
                <td class="label">Pension (Employee)</td>
                <td class="amount">{{ number_format($item->pension_employee, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Income Tax</td>
                <td class="amount">{{ number_format($item->income_tax, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3>Net Pay</h3>
        <table>
            <tr style="font-weight: bold; background: #f0f0f0;">
                <td class="label">NET PAY</td>
                <td class="amount" style="font-size: 18px;">{{ number_format($item->net_pay, 2) }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
```

##### 7.2 Bank Transfer Export (CBE Format)

**File:** `app/Exports/BankTransferExport.php`

```php
<?php

namespace App\Exports;

use App\Models\PayrollRun;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BankTransferExport implements FromCollection, WithHeadings
{
    private $payrollRun;

    public function __construct(PayrollRun $payrollRun)
    {
        $this->payrollRun = $payrollRun;
    }

    public function collection()
    {
        return $this->payrollRun->items()
            ->with('employee')
            ->get()
            ->map(function ($item) {
                return [
                    'account_number' => $item->employee->bank_details,
                    'amount' => $item->net_pay,
                    'description' => 'Salary ' . $this->payrollRun->period_month,
                    'currency' => 'ETB',
                ];
            });
    }

    public function headings(): array
    {
        return ['Account Number', 'Amount', 'Description', 'Currency'];
    }
}
```

##### 7.3 Controller & Routes

**File:** `app/Http/Controllers/PayrollController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\PayrollRun;
use App\Services\PayslipService;
use App\Exports\BankTransferExport;
use Maatwebsite\Excel\Facades\Excel;

class PayrollController extends Controller
{
    public function downloadPayslip(PayrollItem $item)
    {
        $this->authorize('view', $item->payrollRun);

        $service = new PayslipService();
        return $service->generatePayslip($item);
    }

    public function exportBankTransfer(PayrollRun $payrollRun)
    {
        $this->authorize('view', $payrollRun);

        return Excel::download(
            new BankTransferExport($payrollRun),
            "bank_transfer_{$payrollRun->id}.xlsx"
        );
    }
}
```

---

#### 8. COMPLETE PERFORMANCE MANAGEMENT WORKFLOW

**Status:** ⚠️ 30% Done (Models exist, UI & workflow missing)  
**Requirement:** FR-PERF-01 to 06, 6.3  
**Files to Create:** 8-10  
**Effort:** 14-18 hours

> **How-to:** [Full implementation guide](./PERFORMANCE_MANAGEMENT_GUIDE.md)

**Summary:**
- Create goal weight validation (must = 100%)
- Create review form Livewire component
- Implement phase workflow (setting → assessment → manager → HR → published)
- Add HR calibration override with justification
- Implement immutability on published reviews
- Add ESS acknowledgment tracking

---

#### 9. COMPLETE RECRUITMENT & ONBOARDING

**Status:** ⚠️ 40% Done (Models exist, workflows missing)  
**Requirement:** FR-REC-01 to 06, 6.4  
**Files to Create:** 7-9  
**Effort:** 12-16 hours

> **How-to:** [Full implementation guide](./RECRUITMENT_ONBOARDING_GUIDE.md)

**Summary:**
- Create offer letter template engine with merge fields
- Create applicant → hire conversion action
- Auto-generate employee on hire conversion
- Create onboarding checklist model & tracking
- Create onboarding task dashboard with overdue reminders
- Implement email notifications at key milestones

---

#### 10. BUILD REPORTS & ANALYTICS MODULE

**Status:** ❌ 0% Done (Zero implementation)  
**Requirement:** FR-REP-01 to 14  
**Files to Create:** 15+  
**Effort:** 18-22 hours

> **How-to:** [Full implementation guide](./REPORTS_DASHBOARD_GUIDE.md)

**14 Required Reports:**

1. **Employee Headcount Report** (trend by dept, status)
2. **Leave Utilization Report** (by type, employee)
3. **Timesheet Submission Rate** (% submitted, on-time)
4. **Payroll Summary** (gross, deductions, net by dept)
5. **Tax & Pension Report** (employee vs employer)
6. **Benefits Report** (coverage by type)
7. **Performance Rating Distribution** (by cycle, dept)
8. **Training Attendance Report** (by course, employee)
9. **Recruitment Pipeline** (open positions, applicants, conversion rate)
10. **Exit Report** (by reason, dept, date)
11. **Salary Range Compliance** (by position, grade)
12. **Audit Trail Report** (by user, entity type, date)
13. **Attendance Summary** (absences, tardiness by employee)
14. **Overdue Tasks Report** (onboarding, offboarding, training)

---

## 🟢 NICE-TO-HAVE (COULD DO)

### Priority: Post-launch optimization (2-4 weeks)

---

#### 11. DOCUMENT VERSIONING

**Status:** ⚠️ Schema missing parent_document_id  
**Files to Create/Modify:** 2  
**Effort:** 3-4 hours

```php
// Migration: add_parent_document_id_to_documents
Schema::table('employee_documents', function (Blueprint $table) {
    $table->unsignedBigInteger('parent_document_id')->nullable();
    $table->integer('version')->default(1);
    $table->boolean('is_latest')->default(true);
    $table->foreign('parent_document_id')->references('id')->on('employee_documents')->onDelete('cascade');
});
```

---

#### 12. HOLIDAY & WEEKEND CALCULATIONS

**Status:** ❌ Missing  
**Files to Create:** 3  
**Effort:** 4-5 hours

```php
// Create PublicHoliday model & migrate
php artisan make:model PublicHoliday -m

// app/Models/PublicHoliday.php
class PublicHoliday extends Model
{
    public function isHoliday(\Carbon\Carbon $date)
    {
        return static::whereYear('date', $date->year)
            ->whereMonth('date', $date->month)
            ->whereDay('date', $date->day)
            ->exists();
    }
}

// Add to LeaveService
private function countWorkingDays($startDate, $endDate)
{
    $count = 0;
    $current = $startDate->copy();

    while ($current->lte($endDate)) {
        if ($current->isWeekday() && !PublicHoliday::isHoliday($current)) {
            $count++;
        }
        $current->addDay();
    }

    return $count;
}
```

---

#### 13. LEAVE CARRY-OVER POLICY

**Status:** ❌ Missing  
**Files to Create/Modify:** 3  
**Effort:** 3-4 hours

```php
// Add to LeaveType model
public function applyCarryover(Employee $employee, int $year)
{
    $previousBalance = LeaveBalance::where('employee_id', $employee->id)
        ->where('year', $year - 1)
        ->where('leave_type_id', $this->id)
        ->first();

    if (!$previousBalance) return;

    $carryover = match($this->carryover_policy) {
        'none' => 0,
        'limited' => min($previousBalance->remaining, $this->carryover_limit ?? 5),
        'unlimited' => $previousBalance->remaining,
    };

    LeaveBalance::create([
        'employee_id' => $employee->id,
        'leave_type_id' => $this->id,
        'year' => $year,
        'allocated_days' => $this->allowance_days + $carryover,
        'remaining' => $this->allowance_days + $carryover,
    ]);
}
```

---

#### 14. EXIT & OFFBOARDING COMPLETE WORKFLOW

**Status:** ⚠️ 40% Done (Models exist, checklist & deactivation missing)  
**Files to Create:** 4-5  
**Effort:** 8-10 hours

> **How-to:** [Full implementation guide](./OFFBOARDING_GUIDE.md)

---

#### 15. ANNOUNCEMENT & ACKNOWLEDGMENT SYSTEM

**Status:** ❌ Missing (Part of notifications)  
**Files to Create:** 3-4  
**Effort:** 4-6 hours

---

---

## 🧪 TESTING & DOCUMENTATION

### Effort: 2-3 weeks | Can be parallelized

---

### Test Coverage Target: 80%+

#### Current: ~5 tests | Need: 50+ tests

##### Required Test Categories:

1. **Authentication & Authorization (8-10 tests)**
   - Login rate limiting
   - Session timeout
   - Role-based access control
   - Permission middleware

2. **Payroll (10-12 tests)**
   - Tax calculations (10+ scenarios)
   - Pension calculations
   - Idempotency guard
   - Lock enforcement
   - Supplementary run logic
   - PDF generation

3. **Leave Management (8-10 tests)**
   - Overlap detection
   - Balance validation
   - Approval workflow
   - Manager vs HR approval
   - Holiday exclusion

4. **Timesheet (6-8 tests)**
   - Weekly creation
   - Entry submission
   - Supervisor approval
   - Bulk operations
   - Return for correction

5. **Performance Management (6-8 tests)**
   - Goal weight validation
   - Phase transitions
   - HR calibration
   - Published immutability
   - ESS acknowledgment

6. **Recruitment (5-7 tests)**
   - Applicant pipeline
   - Interview scheduling
   - Offer letter generation
   - Hire conversion
   - Onboarding checklist creation

7. **Documents (4-5 tests)**
   - Secure download
   - Version control
   - Expiry tracking
   - Audit logging

8. **Notifications (4-5 tests)**
   - Event dispatch
   - Email sending
   - User preferences
   - Archive after 90 days

9. **Reports (4-6 tests)**
   - Data accuracy
   - Role-based filtering
   - Export formats (Excel, PDF)
   - Pagination

10. **Integration (3-5 tests)**
    - End-to-end leave request → approval → payroll
    - Hire conversion → onboarding workflow
    - Exit → offboarding workflow

---

### Documentation Tasks

1. **API Documentation** (2-3 hours)
   - OpenAPI/Swagger spec
   - Endpoint reference
   - Error codes

2. **User Guides** (4-6 hours per module)
   - HR Admin Manual
   - Manager Manual
   - Employee Manual
   - Payroll Officer Guide

3. **Admin Guide** (3-4 hours)
   - Setup & configuration
   - Backup/restore procedures
   - Troubleshooting
   - Performance tuning

4. **Developer Documentation** (3-4 hours)
   - Architecture overview
   - Component diagrams
   - Database schema
   - Contributing guidelines

---

## 📊 TASK LIST BY MODULE

### Prioritization Matrix

```
MODULE                    STATUS    CRITICAL  EFFORT  TIMELINE
────────────────────────────────────────────────────────────
1. Session Timeout         ❌        🔴        4h     Week 1
2. Payroll Lock            ⚠️        🔴        3h     Week 1
3. Rate Limiting           ❌        🔴        2h     Week 1
4. Leave Approval          ⚠️        🔴        8h     Week 1-2
5. Timesheet Workflow      ⚠️        🔴        12h    Week 2-3
────────────────────────────────────────────────────────────
6. Notifications           ❌        🟡        15h    Week 3-4
7. Payroll Features        ⚠️        🟡        10h    Week 4
8. Performance Mgmt        ⚠️        🟡        14h    Week 4-5
9. Recruitment/Onboard     ⚠️        🟡        12h    Week 5
10. Reports & Dashboard    ❌        🟡        18h    Week 5-6
────────────────────────────────────────────────────────────
11. Document Versioning    ⚠️        🟢        3h     Week 7
12. Holidays/Weekends      ❌        🟢        4h     Week 7
13. Leave Carry-over       ❌        🟢        3h     Week 7
14. Exit/Offboarding       ⚠️        🟢        8h     Week 8
15. Announcements          ❌        🟢        4h     Week 8
────────────────────────────────────────────────────────────
Testing & Documentation                        20h    Parallel
```

---

## 🚀 EXECUTION STRATEGY

### Phase 1: Critical Security & Core Workflows (Weeks 1-3)

```
Week 1:
  Mon-Tue: Session timeout + rate limiting (6h)
  Wed:     Payroll lock enforcement (3h)
  Thu-Fri: Leave approval UI (8h)

Week 2:
  Mon-Tue: Complete leave approval tests (4h)
  Wed-Fri: Timesheet service & UI (12h)

Week 3:
  Mon-Wed: Timesheet UI completion (6h)
  Thu-Fri: Testing & fixes (8h)
```

### Phase 2: High-Priority Features (Weeks 4-5)

```
Week 4:
  Mon-Tue: Notifications system (15h split)
  Wed-Fri: Payroll PDF + exports (10h split)

Week 5:
  Mon-Tue: Performance management workflow (14h split)
  Wed-Fri: Recruitment & onboarding pipeline (12h split)
```

### Phase 3: Reports & Polish (Weeks 6-7)

```
Week 6:
  Mon-Wed: Dashboard & 5 critical reports (10h)
  Thu-Fri: Remaining 9 reports (8h)

Week 7:
  Mon-Tue: Nice-to-have features (12h split)
  Wed-Fri: Testing & documentation (12h)
```

### Week 8: UAT & Deployment Prep

```
Testing in staging environment
Bug fixes & final adjustments
Production deployment plan
User training materials
```

---

## 📝 SUCCESS CRITERIA

### Before Production:

- ✅ All 🔴 critical fixes implemented & tested
- ✅ Test suite: 50+ tests, 80%+ coverage
- ✅ All major workflows tested end-to-end
- ✅ Rate limiting verified
- ✅ Session timeout verified
- ✅ Payroll lock enforcement verified
- ✅ 2-week UAT completion without critical issues
- ✅ Deployment runbook prepared
- ✅ Backup/restore procedures documented
- ✅ User training completed

### Post-Launch:

- Monitor error logs for 2 weeks
- Gather user feedback
- Prioritize bug fixes
- Plan Phase 2 features (nice-to-have items)

---

## 📞 SUPPORT & ESCALATION

### If Stuck:

1. **Design Questions:** Review SRS requirements + existing code patterns
2. **Testing Issues:** Check existing test files for patterns
3. **Livewire Issues:** Consult official docs + examples
4. **Database Issues:** Run migrations in isolation, test with seeders

### Communication Template:

```markdown
**Issue:** [Brief description]
**Context:** [What were you trying to do?]
**Error:** [Exact error message + stack trace]
**Attempted Fix:** [What did you try?]
**SRS Reference:** [FR-XXX-YY section]
```

---

**Last Updated:** 2026-05-24  
**Next Review:** After Phase 1 completion (Week 3)
