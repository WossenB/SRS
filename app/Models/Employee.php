<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasAuditLog;
use App\Traits\HasOptimisticLocking;
use Illuminate\Support\Facades\Crypt;

class Employee extends Model
{
    use SoftDeletes, HasAuditLog, HasOptimisticLocking;

    protected $guarded = ['id', 'version'];

    protected $casts = [
        'date_of_birth' => 'date',
        'hire_date' => 'date',
    ];

    /**
     * Encryption for sensitive fields
     */
    public function setBasicSalaryAttribute($value)
    {
        $this->attributes['basic_salary'] = Crypt::encryptString($value);
    }

    public function getBasicSalaryAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    public function setBankDetailsAttribute($value)
    {
        $this->attributes['bank_details'] = Crypt::encryptString($value);
    }

    public function getBankDetailsAttribute($value)
    {
        if (empty($value)) return null;
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    public function setTinNumberAttribute($value)
    {
        $this->attributes['tin_number'] = Crypt::encryptString($value);
    }

    public function getTinNumberAttribute($value)
    {
        if (empty($value)) return null;
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Employee::class, 'supervisor_id');
    }
}
