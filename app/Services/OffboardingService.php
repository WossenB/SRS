<?php

namespace App\Services;

use App\Models\ExitRecord;
use Illuminate\Support\Facades\DB;

class OffboardingService
{
    public function initiateExit(int $employeeId, array $data)
    {
        return ExitRecord::create(array_merge($data, [
            'employee_id' => $employeeId,
            'status' => 'initiated',
            'clearance_checklist' => [
                'IT' => ['status' => 'pending', 'remarks' => ''],
                'Finance' => ['status' => 'pending', 'remarks' => ''],
                'HR' => ['status' => 'pending', 'remarks' => ''],
                'Supervisor' => ['status' => 'pending', 'remarks' => ''],
            ]
        ]));
    }

    public function completeExit(ExitRecord $exit)
    {
        $checklist = $exit->clearance_checklist;
        foreach ($checklist as $dept => $status) {
            if ($status['status'] === 'pending') {
                throw new \Exception("Cannot complete exit. Clearance from {$dept} is still pending.");
            }
        }

        return DB::transaction(function () use ($exit) {
            $exit->logStatusChange('completed', $exit->status);
            $exit->employee->update(['status' => 'terminated']);

            // Deactivate User Account
            $exit->employee->user->update([
                'email_verified_at' => null, // effectively blocks login if using verified middleware
            ]);

            // In a real system we might also logout all sessions
            return $exit;
        });
    }
}
