<?php

namespace App\Livewire\Performance;

use Livewire\Component;
use App\Models\PerformanceReview;
use App\Services\PerformanceService;
use Illuminate\Support\Facades\Auth;

class PerformanceReviewDetail extends Component
{
    public $review;
    public $self_data = [];
    public $manager_data = [];
    public $final_rating;
    public $hr_remarks;

    public function mount(PerformanceReview $review)
    {
        $this->review = $review;
        $this->self_data = json_decode($review->self_assessment_data, true) ?? [];
        $this->manager_data = json_decode($review->manager_review_data, true) ?? [];
        $this->final_rating = $review->final_rating;
        $this->hr_remarks = $review->hr_remarks;
    }

    public function submitSelf()
    {
        $service = new PerformanceService();
        $service->submitSelfAssessment($this->review, $this->self_data);
        session()->flash('message', 'Self assessment submitted.');
    }

    public function submitManager()
    {
        $service = new PerformanceService();
        $service->submitManagerReview($this->review, $this->manager_data);
        session()->flash('message', 'Manager review submitted.');
    }

    public function calibrate()
    {
        $service = new PerformanceService();
        $service->calibrate($this->review, (float)$this->final_rating, (string)$this->hr_remarks);
        session()->flash('message', 'Calibration saved.');
    }

    public function publish()
    {
        $service = new PerformanceService();
        $service->publishReview($this->review);
        session()->flash('message', 'Review published.');
    }

    public function render()
    {
        return view('livewire.performance.performance-review-detail')->layout('layouts.app');
    }
}
