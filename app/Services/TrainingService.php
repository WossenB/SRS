<?php

namespace App\Services;

use App\Models\TrainingAssignment;
use App\Models\Employee;

class TrainingService
{
    public function nominate(int $employeeId, int $courseId, ?string $dueDate = null)
    {
        return TrainingAssignment::create([
            'employee_id' => $employeeId,
            'training_course_id' => $courseId,
            'due_date' => $dueDate,
            'status' => 'assigned',
        ]);
    }

    public function markComplete(TrainingAssignment $assignment, string $certificatePath)
    {
        $assignment->update([
            'status' => 'completed',
            'completion_date' => now(),
            'certificate_path' => $certificatePath,
        ]);
    }
}
