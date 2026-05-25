<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\SystemSetting;

class SystemSettings extends Component
{
    public $settings = [];

    public function mount()
    {
        $this->settings = SystemSetting::all()->pluck('value', 'key')->toArray();
    }

    public function save()
    {
        foreach ($this->settings as $key => $value) {
            SystemSetting::updateOrCreate(['key' => $key], ['value' => json_encode($value), 'category' => 'general']);
        }
        session()->flash('success', 'Settings updated.');
    }

    public function render()
    {
        return view('livewire.settings.system-settings')->layout('layouts.app');
    }
}
