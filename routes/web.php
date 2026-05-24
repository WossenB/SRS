<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\EmployeeList;
use App\Livewire\Leave\LeaveIndex;
use App\Livewire\Leave\LeaveRequestForm;
use App\Livewire\Leave\LeaveApprovalManager;
use App\Livewire\Timesheet\TimesheetIndex;
use App\Livewire\Timesheet\TimesheetGrid;
use App\Livewire\Timesheet\TimesheetApproval;
use App\Livewire\Recruitment\JobOpeningList;
use App\Livewire\Payroll\PayrollRunList;
use App\Livewire\Training\CourseList;
use App\Livewire\Offboarding\ExitRecordList;
use App\Http\Controllers\DocumentController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth',
    'verified',
])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Employee Management
    Route::get('/employees', EmployeeList::class)->name('employees.index')->middleware('can:employee.create');

    // Leave Management
    Route::get('/leave', LeaveIndex::class)->name('leave.index');
    Route::get('/leave/request', LeaveRequestForm::class)->name('leave.request');
    Route::get('/leave/approvals', LeaveApprovalManager::class)->name('leave.approvals')->middleware('can:leave.approve_manager');

    // Timesheet Management
    Route::get('/timesheets', TimesheetIndex::class)->name('timesheet.index');
    Route::get('/timesheets/{timesheet}/edit', TimesheetGrid::class)->name('timesheet.edit');
    Route::get('/timesheets/approvals', TimesheetApproval::class)->name('timesheet.approvals')->middleware('can:timesheet.approve_supervisor');

    // Recruitment
    Route::get('/recruitment', JobOpeningList::class)->name('recruitment.index')->middleware('can:applicant.manage');

    // Payroll Management
    Route::get('/payroll', PayrollRunList::class)->name('payroll.index')->middleware('can:payroll.initiate');

    // Training
    Route::get('/training', CourseList::class)->name('training.index');

    // Offboarding
    Route::get('/offboarding', ExitRecordList::class)->name('offboarding.index')->middleware('can:employee.purge');

    // Documents
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
});
