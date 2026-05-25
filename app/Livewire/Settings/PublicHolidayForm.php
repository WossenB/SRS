<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\PublicHoliday;

class PublicHolidayForm extends Component
{
    public $name, $date;

    public function save()
    {
        $this->validate(['name' => 'required', 'date' => 'required|date']);
        PublicHoliday::create(['name' => $this->name, 'date' => $this->date]);
        return redirect()->route('settings.holidays.index');
    }

    public function render()
    {
        return view('livewire.settings.public-holiday-form')->layout('layouts.app');
    }
}
