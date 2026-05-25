<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\WorkSchedule;

class WorkScheduleList extends Component
{
    public function render()
    {
        return view('livewire.settings.work-schedule-list', [
            'schedules' => WorkSchedule::all()
        ])->layout('layouts.app');
    }
}
