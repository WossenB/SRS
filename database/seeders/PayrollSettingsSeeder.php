<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaxSlab;
use App\Models\PensionRate;

class PayrollSettingsSeeder extends Seeder
{
    public function run(): void
    {
        // Ethiopian Tax Slabs (2025/Sample)
        $slabs = [
            ['min_income' => 0, 'max_income' => 600, 'rate' => 0, 'deduction' => 0],
            ['min_income' => 601, 'max_income' => 1650, 'rate' => 10, 'deduction' => 60],
            ['min_income' => 1651, 'max_income' => 3200, 'rate' => 15, 'deduction' => 142.5],
            ['min_income' => 3201, 'max_income' => 5250, 'rate' => 20, 'deduction' => 302.5],
            ['min_income' => 5251, 'max_income' => 7800, 'rate' => 25, 'deduction' => 565],
            ['min_income' => 7801, 'max_income' => 10900, 'rate' => 30, 'deduction' => 955],
            ['min_income' => 10901, 'max_income' => null, 'rate' => 35, 'deduction' => 1500],
        ];

        foreach ($slabs as $slab) {
            TaxSlab::create($slab);
        }

        PensionRate::create([
            'name' => 'Public/Private Sector Standard',
            'employee_rate' => 7.00,
            'employer_rate' => 11.00,
            'is_active' => true,
        ]);
    }
}
