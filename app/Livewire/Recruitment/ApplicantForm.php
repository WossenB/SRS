<?php

namespace App\Livewire\Recruitment;

use Livewire\Component;
use App\Models\Applicant;
use App\Models\JobOpening;

class ApplicantForm extends Component
{
    public $job_opening_id;
    public $first_name, $last_name, $email, $phone;

    public function mount($jobId = null)
    {
        $this->job_opening_id = $jobId;
    }

    public function save()
    {
        $this->validate([
            'job_opening_id' => 'required|exists:job_openings,id',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
        ]);

        Applicant::create([
            'job_opening_id' => $this->job_opening_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => 'applied',
        ]);

        return redirect()->route('recruitment.show', $this->job_opening_id);
    }

    public function render()
    {
        return view('livewire.recruitment.applicant-form', [
            'jobs' => JobOpening::where('status', 'open')->get()
        ])->layout('layouts.app');
    }
}
