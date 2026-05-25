<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\SystemSetting;
use App\Models\TaxSlab;
use App\Models\PensionRate;

class SystemSettings extends Component
{
    public $settings = [];
    public $taxSlabs = [];
    public $pension;

    public function mount()
    {
        $this->settings = SystemSetting::all()->pluck('value', 'key')->toArray();
        $this->taxSlabs = TaxSlab::all()->toArray();
        $this->pension = PensionRate::where('is_active', true)->first()?->toArray();
    }

    public function save()
    {
        // General settings
        foreach ($this->settings as $key => $value) {
            SystemSetting::updateOrCreate(['key' => $key], ['value' => json_encode($value), 'category' => 'general']);
        }

        // Tax slabs
        foreach ($this->taxSlabs as $slab) {
            TaxSlab::where('id', $slab['id'])->update([
                'min_income' => $slab['min_income'],
                'max_income' => $slab['max_income'],
                'rate' => $slab['rate'],
                'deduction' => $slab['deduction'],
            ]);
        }

        session()->flash('success', 'System configuration updated.');
    }

    public function render()
    {
        return view('livewire.settings.system-settings')->layout('layouts.app');
    }
}
