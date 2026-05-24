<?php

namespace App\Livewire\ESS;

use Livewire\Component;
use App\Models\EmployeeBenefit;
use Illuminate\Support\Facades\Auth;

class MyBenefits extends Component
{
    public function render()
    {
        $benefits = EmployeeBenefit::where('employee_id', Auth::user()->employee?->id)
            ->where('is_active', true)
            ->with('catalog')
            ->get();

        return view('livewire.ess.my-benefits', [
            'benefits' => $benefits
        ])->layout('layouts.app');
    }
}
