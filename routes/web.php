<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\EmployeeList;
use App\Http\Controllers\DocumentController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Employee Management
    Route::get('/employees', EmployeeList::class)->name('employees.index')->middleware('can:employee.create');

    // Leave Management
    Route::get('/leave', function() { return 'My Leave'; })->name('leave.index');
    Route::get('/approvals/leave', function() { return 'Leave Approvals'; })->name('leave.approvals')->middleware('can:leave.approve_manager');

    // Payroll Management
    Route::get('/payroll', function() { return 'Payroll Runs'; })->name('payroll.index')->middleware('can:payroll.initiate');

    // Documents
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
});
