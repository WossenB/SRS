<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait HasAuditLog
{
    public static function bootHasAuditLog()
    {
        static::updated(function ($model) {
            $changes = $model->getChanges();
            if (empty($changes)) return;

            $before = array_intersect_key($model->getOriginal(), $changes);

            DB::table('audit_logs')->insert([
                'action_type' => 'update',
                'correlation_id' => request()->header('X-Correlation-ID') ?? (string) Str::uuid(),
                'user_id' => Auth::id(),
                'before_json' => json_encode($before),
                'after_json' => json_encode($changes),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
            ]);
        });

        static::deleted(function ($model) {
            DB::table('audit_logs')->insert([
                'action_type' => 'delete',
                'correlation_id' => request()->header('X-Correlation-ID') ?? (string) Str::uuid(),
                'user_id' => Auth::id(),
                'before_json' => json_encode($model->getOriginal()),
                'after_json' => null,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
            ]);
        });
    }
}
