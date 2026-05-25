<?php

namespace App\Livewire\Payroll;

use Livewire\Component;
use App\Services\PayrollService;
use Illuminate\Support\Facades\Auth;

class PayrollRunCreate extends Component
{
    public $period_month;
    public $run_type = 'regular';

    public function create()
    {
        $this->validate([
            'period_month' => 'required|date_format:Y-m',
            'run_type' => 'required|in:regular,supplementary',
        ]);

        try {
            $service = new PayrollService();
            $run = $service->initiateRun($this->period_month, $this->run_type, Auth::id());
            return redirect()->route('payroll.details', $run->id);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.payroll.payroll-run-create')->layout('layouts.app');
    }
}
