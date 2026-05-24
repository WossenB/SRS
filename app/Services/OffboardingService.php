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

        $exit->logStatusChange('completed', $exit->status);
        $exit->employee->update(['status' => 'terminated']);
    }
}
