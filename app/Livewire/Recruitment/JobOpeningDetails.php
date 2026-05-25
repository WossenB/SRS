<?php

namespace App\Livewire\Recruitment;

use Livewire\Component;
use App\Models\JobOpening;
use App\Models\Applicant;

class JobOpeningDetails extends Component
{
    public $job;

    public function mount(JobOpening $job)
    {
        $this->job = $job;
    }

    public function updateStatus($applicantId, $status)
    {
        Applicant::findOrFail($applicantId)->update(['status' => $status]);
        session()->flash('message', 'Applicant status updated.');
    }

    public function render()
    {
        $applicants = Applicant::where('job_opening_id', $this->job->id)->get();
        return view('livewire.recruitment.job-opening-details', [
            'applicants' => $applicants
        ])->layout('layouts.app');
    }
}
