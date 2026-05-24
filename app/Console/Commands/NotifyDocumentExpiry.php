<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EmployeeDocument;
use App\Notifications\SystemNotification;

class NotifyDocumentExpiry extends Command
{
    protected $signature = 'notify:doc-expiry';
    protected $description = 'Notify employees about expiring documents';

    public function handle()
    {
        $expiring = EmployeeDocument::where('expiry_date', '<=', now()->addDays(30))
            ->where('expiry_date', '>', now())
            ->get();

        foreach ($expiring as $doc) {
            $doc->employee->user->notify(new SystemNotification(
                "Document Expiring",
                "Your document '{$doc->title}' expires on {$doc->expiry_date->format('Y-m-d')}."
            ));
        }
    }
}
