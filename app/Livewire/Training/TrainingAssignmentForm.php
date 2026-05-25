<?php

namespace App\Livewire\Training;

use Livewire\Component;
use App\Models\TrainingCourse;
use App\Models\Employee;
use App\Services\TrainingService;

class TrainingAssignmentForm extends Component
{
    public $employee_id, $training_course_id, $due_date;

    public function save()
    {
        $this->validate([
            'employee_id' => 'required|exists:employees,id',
            'training_course_id' => 'required|exists:training_courses,id',
        ]);

        $service = new TrainingService();
        $service->nominate($this->employee_id, $this->training_course_id, $this->due_date);

        session()->flash('success', 'Training assigned successfully!');
        return redirect()->route('training.index');
    }

    public function render()
    {
        return view('livewire.training.training-assignment-form', [
            'employees' => Employee::all(),
            'courses' => TrainingCourse::all(),
        ])->layout('layouts.app');
    }
}
