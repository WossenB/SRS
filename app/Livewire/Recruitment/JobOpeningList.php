<?php

namespace App\Livewire\Recruitment;

use Livewire\Component;
use App\Models\JobOpening;
use Livewire\WithPagination;

class JobOpeningList extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.recruitment.job-opening-list', [
            'jobs' => JobOpening::latest()->paginate(10)
        ])->layout('layouts.app');
    }
}
