<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait HasStatusHistory
{
    public function logStatusChange(string $toStatus, ?string $fromStatus = null, ?array $metadata = [])
    {
        DB::table('status_logs')->insert([
            'entity_type' => get_class($this),
            'entity_id' => $this->id,
            'from_status' => $fromStatus ?? $this->status ?? null,
            'to_status' => $toStatus,
            'metadata' => json_encode($metadata),
            'correlation_id' => request()->header('X-Correlation-ID') ?? (string) Str::uuid(),
            'user_id' => Auth::id(),
            'created_at' => now(),
        ]);

        $this->status = $toStatus;
        $this->save();
    }
}
