<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasAuditLog;
use App\Traits\HasStatusHistory;
use App\Traits\HasOptimisticLocking;

class ExitRecord extends Model
{
    use SoftDeletes, HasAuditLog, HasStatusHistory, HasOptimisticLocking;

    protected $guarded = ['id', 'version'];

    protected $casts = [
        'separation_date' => 'date',
        'clearance_checklist' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
