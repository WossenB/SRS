<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasImmutableFields;

class PayrollItem extends Model
{
    use HasImmutableFields;

    protected $guarded = ['id'];

    protected $immutableFields = ['employee_id', 'payroll_run_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
