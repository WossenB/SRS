<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            PayrollSettingsSeeder::class,
        ]);

        $admin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@birrama.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Super Admin');
    }
}
