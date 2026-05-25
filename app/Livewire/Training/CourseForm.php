<?php

namespace App\Livewire\Training;

use Livewire\Component;
use App\Models\TrainingCourse;

class CourseForm extends Component
{
    public $courseId;
    public $title, $description, $provider, $duration_hours, $category;

    public function mount($id = null)
    {
        if ($id) {
            $course = TrainingCourse::findOrFail($id);
            $this->courseId = $id;
            $this->title = $course->title;
            $this->description = $course->description;
            $this->provider = $course->provider;
            $this->duration_hours = $course->duration_hours;
            $this->category = $course->category;
        }
    }

    public function save()
    {
        $this->validate(['title' => 'required', 'category' => 'required']);

        TrainingCourse::updateOrCreate(['id' => $this->courseId], [
            'title' => $this->title,
            'description' => $this->description,
            'provider' => $this->provider,
            'duration_hours' => $this->duration_hours,
            'category' => $this->category,
        ]);

        return redirect()->route('training.index');
    }

    public function render()
    {
        return view('livewire.training.course-form')->layout('layouts.app');
    }
}
