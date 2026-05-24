<?php

namespace App\Livewire\Offboarding;

use Livewire\Component;
use App\Models\ExitRecord;
use Livewire\WithPagination;

class ExitRecordList extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.offboarding.exit-record-list', [
            'exits' => ExitRecord::latest()->paginate(10)
        ])->layout('layouts.app');
    }
}
