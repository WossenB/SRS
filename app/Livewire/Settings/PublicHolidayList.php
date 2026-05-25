<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\PublicHoliday;

class PublicHolidayList extends Component
{
    public function delete($id)
    {
        PublicHoliday::findOrFail($id)->delete();
        session()->flash('message', 'Holiday deleted.');
    }

    public function render()
    {
        return view('livewire.settings.public-holiday-list', [
            'holidays' => PublicHoliday::orderBy('date')->get()
        ])->layout('layouts.app');
    }
}
