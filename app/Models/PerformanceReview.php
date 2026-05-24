<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditLog;
use App\Traits\HasStatusHistory;
use App\Traits\HasOptimisticLocking;

class PerformanceReview extends Model
{
    use HasAuditLog, HasStatusHistory, HasOptimisticLocking;

    protected $guarded = ['id', 'version'];
}
