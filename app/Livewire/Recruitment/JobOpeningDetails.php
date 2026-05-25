<?php

namespace App\Livewire\Recruitment;

use Livewire\Component;
use App\Models\JobOpening;
use App\Models\Applicant;
use App\Models\Interview;

class JobOpeningDetails extends Component
{
    public $job;
    public $selectedApplicant;
    public $score;
    public $feedback;

    public function mount(JobOpening $job)
    {
        $this->job = $job;
    }

    public function updateStatus($applicantId, $status)
    {
        Applicant::findOrFail($applicantId)->update(['status' => $status]);
        session()->flash('message', 'Applicant status updated.');
    }

    public function selectApplicant($id)
    {
        $this->selectedApplicant = Applicant::find($id);
    }

    public function submitScore()
    {
        $this->validate([
            'score' => 'required|numeric|min:1|max:5',
            'feedback' => 'required'
        ]);

        Interview::create([
            'applicant_id' => $this->selectedApplicant->id,
            'interview_date' => now(),
            'score' => $this->score,
            'feedback' => $this->feedback,
            'status' => 'completed',
        ]);

        $this->reset(['score', 'feedback', 'selectedApplicant']);
        session()->flash('message', 'Interview score recorded.');
    }

    public function render()
    {
        $applicants = Applicant::where('job_opening_id', $this->job->id)->get();
        return view('livewire.recruitment.job-opening-details', [
            'applicants' => $applicants
        ])->layout('layouts.app');
    }
}
