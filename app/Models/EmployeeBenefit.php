<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeBenefit extends Model
{
    protected $guarded = ['id'];

    public function catalog()
    {
        return $this->belongsTo(BenefitCatalog::class, 'benefit_catalog_id');
    }
}
