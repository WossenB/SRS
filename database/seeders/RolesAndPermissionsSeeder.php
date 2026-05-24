<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'system.manage',
            'payroll.approve',
            'payroll.initiate',
            'payroll.review',
            'employee.create',
            'employee.edit',
            'employee.purge',
            'document.verify',
            'document.upload_personal',
            'leave.request',
            'leave.approve_manager',
            'leave.approve_hr',
            'timesheet.submit',
            'timesheet.approve_supervisor',
            'performance.cycle_manage',
            'performance.review_manager',
            'training.mark_complete',
            'applicant.manage',
            'settings.manage',
            'report.export',
            'audit.view',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        Role::create(['name' => 'Super Admin'])->givePermissionTo(Permission::all());

        Role::create(['name' => 'HR Admin'])->givePermissionTo([
            'employee.create', 'employee.edit', 'payroll.initiate', 'payroll.review',
            'leave.approve_hr', 'performance.cycle_manage', 'report.export', 'applicant.manage',
            'document.verify'
        ]);

        Role::create(['name' => 'HR Officer'])->givePermissionTo([
            'employee.create', 'document.verify', 'training.mark_complete', 'applicant.manage'
        ]);

        Role::create(['name' => 'Department Manager'])->givePermissionTo([
            'leave.approve_manager', 'timesheet.approve_supervisor', 'performance.review_manager'
        ]);

        Role::create(['name' => 'Employee'])->givePermissionTo([
            'leave.request', 'timesheet.submit', 'document.upload_personal'
        ]);
    }
}
