<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminCredentialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create PSO Admin
        Admin::firstOrCreate(
            ['email' => 'pso@clsu.edu.ph'],
            [
                'name' => 'PSO Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'pso_admin',
                'is_active' => true,
            ]
        );

        // Create RMO Admin
        Admin::firstOrCreate(
            ['email' => 'rmo@clsu.edu.ph'],
            [
                'name' => 'RMO Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'rmo_admin',
                'is_active' => true,
            ]
        );
    }
}
