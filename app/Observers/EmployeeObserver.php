<?php

namespace App\Observers;

use App\Models\Employee;
use App\Models\EmployeeHistory;
use Illuminate\Support\Facades\Auth;

class EmployeeObserver
{
    public function updated(Employee $employee): void
    {
        $changes = $employee->getChanges();
        $relevantFields = ['basic_salary', 'position_id', 'department_id'];

        $changeType = null;
        if (array_key_exists('basic_salary', $changes)) $changeType = 'salary_change';
        elseif (array_key_exists('position_id', $changes)) $changeType = 'position_change';
        elseif (array_key_exists('department_id', $changes)) $changeType = 'department_transfer';

        if ($changeType) {
            EmployeeHistory::create([
                'employee_id' => $employee->id,
                'change_type' => $changeType,
                'before_json' => json_encode(array_intersect_key($employee->getOriginal(), array_flip($relevantFields))),
                'after_json' => json_encode(array_intersect_key($changes, array_flip($relevantFields))),
                'effective_date' => now(),
                'approved_by' => Auth::id(),
                'created_at' => now(),
            ]);
        }
    }
}
