<?php
namespace App\Livewire\Settings;
use Livewire\Component;
use App\Models\WorkSchedule;
class WorkScheduleForm extends Component {
    public $name, $standard_hours = 8, $working_days = [];
    public function save() {
        WorkSchedule::create(['name' => $this->name, 'standard_hours' => $this->standard_hours, 'working_days_json' => json_encode($this->working_days)]);
        return redirect()->route('settings.schedules.index');
    }
    public function render() { return view('livewire.settings.work-schedule-form')->layout('layouts.app'); }
}
