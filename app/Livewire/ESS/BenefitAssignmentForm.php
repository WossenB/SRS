<?php

namespace App\Livewire\ESS;

use Livewire\Component;
use App\Models\BenefitCatalog;
use App\Models\Employee;
use App\Models\EmployeeBenefit;

class BenefitAssignmentForm extends Component
{
    public $employee_id, $benefit_catalog_id, $amount, $start_date;

    public function save()
    {
        $this->validate([
            'employee_id' => 'required|exists:employees,id',
            'benefit_catalog_id' => 'required|exists:benefit_catalogs,id',
            'amount' => 'required|numeric',
            'start_date' => 'required|date',
        ]);

        EmployeeBenefit::create([
            'employee_id' => $this->employee_id,
            'benefit_catalog_id' => $this->benefit_catalog_id,
            'amount' => $this->amount,
            'start_date' => $this->start_date,
            'is_active' => true,
        ]);

        return redirect()->route('employees.index');
    }

    public function render()
    {
        return view('livewire.ess.benefit-assignment-form', [
            'employees' => Employee::all(),
            'catalogs' => BenefitCatalog::all(),
        ])->layout('layouts.app');
    }
}
