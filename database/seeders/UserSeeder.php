<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test user if not exists
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('123456'),
                'phone' => '+2 01234567890',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Test user created successfully!');
        $this->command->info('Email: test@example.com');
        $this->command->info('Password: 123456');
    }
}

