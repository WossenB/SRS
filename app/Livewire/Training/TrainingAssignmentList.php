<?php

namespace App\Livewire\Training;

use Livewire\Component;
use App\Models\TrainingAssignment;
use Livewire\WithPagination;

class TrainingAssignmentList extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.training.training-assignment-list', [
            'assignments' => TrainingAssignment::with(['employee', 'course'])->latest()->paginate(10)
        ])->layout('layouts.app');
    }
}
