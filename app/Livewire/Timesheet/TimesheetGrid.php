<?php

namespace App\Livewire\Timesheet;

use Livewire\Component;
use App\Models\Timesheet;
use App\Services\TimesheetService;
use Illuminate\Support\Facades\Auth;

class TimesheetGrid extends Component
{
    public $timesheet;
    public $entries = [];

    public function mount(Timesheet $timesheet)
    {
        $this->timesheet = $timesheet;
        $this->entries = $timesheet->entries->mapWithKeys(fn($e) => [$e->id => $e->toArray()])->toArray();
    }

    public function submit()
    {
        $this->authorize('submit', $this->timesheet);

        $service = new TimesheetService();
        $service->submitTimesheet($this->timesheet, $this->entries);

        session()->flash('success', 'Timesheet submitted!');
    }

    public function render()
    {
        return view('livewire.timesheet.timesheet-grid')->layout('layouts.app');
    }
}
