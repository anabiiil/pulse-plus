<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Admin Seeder
 *
 * Seeds the database with admin users for testing and development purposes.
 *
 * @package Database\Seeders
 */
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates a default admin user and optionally additional test admins.
     *
     * @return void
     */
    public function run(): void
    {
        // Create a default admin with known credentials for testing
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
    }
}

