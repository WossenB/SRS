<?php

namespace App\Livewire\Offboarding;

use Livewire\Component;
use App\Models\ExitRecord;
use App\Services\OffboardingService;

class ExitRecordDetail extends Component
{
    public $exit;
    public $checklist = [];

    public function mount(ExitRecord $exit)
    {
        $this->exit = $exit;
        $this->checklist = $exit->clearance_checklist ?? [];
    }

    public function updateChecklist($dept, $status)
    {
        $this->checklist[$dept]['status'] = $status;
        $this->exit->update(['clearance_checklist' => $this->checklist]);
        session()->flash('message', 'Checklist updated.');
    }

    public function complete()
    {
        try {
            $service = new OffboardingService();
            $service->completeExit($this->exit);
            session()->flash('message', 'Offboarding completed. Employee deactivated.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.offboarding.exit-record-detail')->layout('layouts.app');
    }
}
