<?php

namespace App\Livewire\Training;

use Livewire\Component;
use App\Models\TrainingCourse;
use Livewire\WithPagination;

class CourseList extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.training.course-list', [
            'courses' => TrainingCourse::latest()->paginate(10)
        ])->layout('layouts.app');
    }
}
