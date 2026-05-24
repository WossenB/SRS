<?php

namespace App\Livewire\Payroll;

use Livewire\Component;
use App\Models\PayrollRun;
use Livewire\WithPagination;

class PayrollRunList extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.payroll.payroll-run-list', [
            'runs' => PayrollRun::latest()->paginate(10)
        ])->layout('layouts.app');
    }
}
