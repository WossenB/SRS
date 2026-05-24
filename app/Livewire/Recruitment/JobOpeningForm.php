<?php

namespace App\Livewire\Recruitment;

use Livewire\Component;
use App\Models\JobOpening;
use App\Models\Department;

class JobOpeningForm extends Component
{
    public $jobId;
    public $title, $department_id, $description, $closing_date;

    public function mount($id = null)
    {
        if ($id) {
            $job = JobOpening::findOrFail($id);
            $this->jobId = $id;
            $this->title = $job->title;
            $this->department_id = $job->department_id;
            $this->description = $job->description;
            $this->closing_date = $job->closing_date?->format('Y-m-d');
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required',
            'department_id' => 'required|exists:departments,id',
            'description' => 'required',
        ]);

        JobOpening::updateOrCreate(['id' => $this->jobId], [
            'title' => $this->title,
            'department_id' => $this->department_id,
            'description' => $this->description,
            'closing_date' => $this->closing_date,
        ]);

        return redirect()->route('recruitment.index');
    }

    public function render()
    {
        return view('livewire.recruitment.job-opening-form', [
            'departments' => Department::all()
        ])->layout('layouts.app');
    }
}
