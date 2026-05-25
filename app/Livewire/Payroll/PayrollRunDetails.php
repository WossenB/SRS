<?php

namespace App\Livewire\Payroll;

use Livewire\Component;
use App\Models\PayrollRun;
use App\Models\PayrollItem;
use App\Services\PayrollService;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PayrollExport;

class PayrollRunDetails extends Component
{
    public $run;

    public function mount(PayrollRun $run)
    {
        $this->run = $run;
    }

    public function lock()
    {
        $this->authorize('lock', $this->run);
        $service = new PayrollService();
        $service->lockPayrollRun($this->run, Auth::id());
        $this->run->refresh();
    }

    public function export()
    {
        // SRS: Log export to audit log
        DB::table('audit_logs')->insert([
            'action_type' => 'payroll_export',
            'user_id' => Auth::id(),
            'after_json' => json_encode(['payroll_run_id' => $this->run->id]),
            'created_at' => now(),
        ]);

        return Excel::download(new PayrollExport($this->run->id), "payroll_{$this->run->period_month}.xlsx");
    }

    public function render()
    {
        $items = PayrollItem::where('payroll_run_id', $this->run->id)->with('employee')->get();
        return view('livewire.payroll.payroll-run-details', ['items' => $items])->layout('layouts.app');
    }
}
