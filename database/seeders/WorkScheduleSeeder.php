<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkSchedule;

class WorkScheduleSeeder extends Seeder
{
    public function run(): void
    {
        WorkSchedule::create([
            'name' => 'Standard 40h Week',
            'working_days_json' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            'standard_hours' => 8,
            'is_default' => true,
        ]);
    }
}
