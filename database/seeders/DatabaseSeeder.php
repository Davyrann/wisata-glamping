<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Required Demo Accounts from PRD
        User::firstOrCreate(
            ['email' => 'admin@demo.test'],
            [
                'name' => 'Administrator Glamping',
                'password' => bcrypt('Admin#2026'),
                'role' => 'admin',
                'phone' => '081234567890',
            ]
        );

        User::firstOrCreate(
            ['email' => 'staff@demo.test'],
            [
                'name' => 'Staff Operasional',
                'password' => bcrypt('Staff#2026'),
                'role' => 'staff',
                'phone' => '081234567891',
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@demo.test'],
            [
                'name' => 'Tamu Demo',
                'password' => bcrypt('User#2026'),
                'role' => 'user',
                'phone' => '081234567892',
            ]
        );
    }
}
