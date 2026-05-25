<?php

namespace App\Livewire\Performance;

use Livewire\Component;
use App\Models\PerformanceReview;
use Livewire\WithPagination;

class PerformanceReviewList extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.performance.performance-review-list', [
            'reviews' => PerformanceReview::with('employee')->latest()->paginate(10)
        ])->layout('layouts.app');
    }
}
