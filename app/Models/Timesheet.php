<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasAuditLog;
use App\Traits\HasStatusHistory;
use App\Traits\HasOptimisticLocking;

class Timesheet extends Model
{
    use SoftDeletes, HasAuditLog, HasStatusHistory, HasOptimisticLocking;

    protected $guarded = ['id', 'version'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function entries()
    {
        return $this->hasMany(TimesheetEntry::class);
    }
}
