<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\EmployeeList;
use App\Livewire\Employee\EmployeeForm;
use App\Livewire\Employee\EmployeeDetails;
use App\Livewire\Employee\DocumentVerificationList;
use App\Livewire\Leave\LeaveIndex;
use App\Livewire\Leave\LeaveRequestForm;
use App\Livewire\Leave\LeaveApprovalManager;
use App\Livewire\Timesheet\TimesheetIndex;
use App\Livewire\Timesheet\TimesheetGrid;
use App\Livewire\Timesheet\TimesheetApproval;
use App\Livewire\Recruitment\JobOpeningList;
use App\Livewire\Recruitment\JobOpeningForm;
use App\Livewire\Recruitment\JobOpeningDetails;
use App\Livewire\Recruitment\ApplicantForm;
use App\Livewire\Payroll\PayrollRunList;
use App\Livewire\Payroll\PayrollRunCreate;
use App\Livewire\Payroll\PayrollRunDetails;
use App\Livewire\Training\CourseList;
use App\Livewire\Training\CourseForm;
use App\Livewire\Training\TrainingAssignmentForm;
use App\Livewire\Training\TrainingAssignmentList;
use App\Livewire\Performance\PerformanceReviewList;
use App\Livewire\Performance\PerformanceReviewDetail;
use App\Livewire\Offboarding\ExitRecordList;
use App\Livewire\Offboarding\OffboardingForm;
use App\Livewire\Offboarding\ExitRecordDetail;
use App\Livewire\Announcements\AnnouncementList;
use App\Livewire\Announcements\AnnouncementForm;
use App\Livewire\Notifications\NotificationList;
use App\Livewire\System\AuditLogList;
use App\Livewire\ESS\MyBenefits;
use App\Livewire\ESS\MyDocuments;
use App\Livewire\ESS\BenefitAssignmentForm;
use App\Livewire\ESS\PersonalProfile;
use App\Livewire\Benefit\BenefitCatalogForm;
use App\Livewire\Benefit\BenefitCatalogList;
use App\Livewire\ReportsDashboard;
use App\Livewire\Settings\SystemSettings;
use App\Livewire\Settings\PublicHolidayList;
use App\Livewire\Settings\PublicHolidayForm;
use App\Livewire\Settings\WorkScheduleList;
use App\Livewire\Settings\WorkScheduleForm;
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
    Route::get('/employees/create', EmployeeForm::class)->name('employees.create')->middleware('can:employee.create');
    Route::get('/employees/verify-docs', DocumentVerificationList::class)->name('employees.verify_docs')->middleware('can:document.verify');
    Route::get('/employees/{employee}', EmployeeDetails::class)->name('employees.show')->middleware('can:employee.create');
    Route::get('/employees/{id}/edit', EmployeeForm::class)->name('employees.edit')->middleware('can:employee.edit');

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
    Route::get('/recruitment/create', JobOpeningForm::class)->name('recruitment.create')->middleware('can:applicant.manage');
    Route::get('/recruitment/{job}', JobOpeningDetails::class)->name('recruitment.show')->middleware('can:applicant.manage');
    Route::get('/recruitment/{job}/apply', ApplicantForm::class)->name('recruitment.apply')->middleware('can:applicant.manage');

    // Payroll Management
    Route::get('/payroll', PayrollRunList::class)->name('payroll.index')->middleware('can:payroll.initiate');
    Route::get('/payroll/create', PayrollRunCreate::class)->name('payroll.create')->middleware('can:payroll.initiate');
    Route::get('/payroll/{run}', PayrollRunDetails::class)->name('payroll.details')->middleware('can:payroll.review');

    // ESS & Benefits
    Route::get('/my-benefits', MyBenefits::class)->name('ess.benefits');
    Route::get('/my-documents', MyDocuments::class)->name('ess.documents');
    Route::get('/profile', PersonalProfile::class)->name('ess.profile');

    // Benefits Management
    Route::get('/benefits/catalog', BenefitCatalogList::class)->name('benefits.index')->middleware('can:benefit.catalog');
    Route::get('/benefits/create', BenefitCatalogForm::class)->name('benefits.create')->middleware('can:benefit.catalog');
    Route::get('/benefits/assign', BenefitAssignmentForm::class)->name('benefits.assign')->middleware('can:benefit.catalog');

    // Training
    Route::get('/training', CourseList::class)->name('training.index');
    Route::get('/training/create', CourseForm::class)->name('training.create');
    Route::get('/training/assign', TrainingAssignmentForm::class)->name('training.assign');
    Route::get('/training/assignments', TrainingAssignmentList::class)->name('training.assignments');

    // Performance
    Route::get('/performance', PerformanceReviewList::class)->name('performance.index');
    Route::get('/performance/{review}', PerformanceReviewDetail::class)->name('performance.show');

    // Announcements & Notifications
    Route::get('/announcements', AnnouncementList::class)->name('announcements.index');
    Route::get('/announcements/create', AnnouncementForm::class)->name('announcements.create')->middleware('can:system.manage');
    Route::get('/notifications', NotificationList::class)->name('notifications.index');

    // Offboarding
    Route::get('/offboarding', ExitRecordList::class)->name('offboarding.index')->middleware('can:employee.purge');
    Route::get('/offboarding/initiate/{employeeId}', OffboardingForm::class)->name('offboarding.initiate')->middleware('can:employee.purge');
    Route::get('/offboarding/{exit}', ExitRecordDetail::class)->name('offboarding.show')->middleware('can:employee.purge');

    // Reports
    Route::get('/reports', ReportsDashboard::class)->name('reports.index')->middleware('can:report.export');

    // Settings & Audit
    Route::get('/settings', SystemSettings::class)->name('settings.index')->middleware('role:Super Admin');
    Route::get('/settings/holidays', PublicHolidayList::class)->name('settings.holidays.index')->middleware('role:Super Admin');
    Route::get('/settings/holidays/create', PublicHolidayForm::class)->name('settings.holidays.create')->middleware('role:Super Admin');
    Route::get('/settings/schedules', WorkScheduleList::class)->name('settings.schedules.index')->middleware('role:Super Admin');
    Route::get('/settings/schedules/create', WorkScheduleForm::class)->name('settings.schedules.create')->middleware('role:Super Admin');
    Route::get('/audit', AuditLogList::class)->name('audit.index')->middleware('role:Super Admin');

    // Documents
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
});
