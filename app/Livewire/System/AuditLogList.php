<?php

namespace App\Livewire\System;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class AuditLogList extends Component
{
    use WithPagination;

    public function render()
    {
        $logs = DB::table('audit_logs')
            ->join('users', 'audit_logs.user_id', '=', 'users.id')
            ->select('audit_logs.*', 'users.name as user_name')
            ->latest('created_at')
            ->paginate(20);

        return view('livewire.system.audit-log-list', ['logs' => $logs])->layout('layouts.app');
    }
}
