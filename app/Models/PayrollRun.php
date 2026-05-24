<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAuditLog;
use App\Traits\HasStatusHistory;
use App\Traits\HasOptimisticLocking;
use App\Traits\HasImmutableFields;

class PayrollRun extends Model
{
    use HasAuditLog, HasStatusHistory, HasOptimisticLocking, HasImmutableFields;

    protected $guarded = ['id', 'version'];

    protected $immutableFields = ['period_month'];
}
