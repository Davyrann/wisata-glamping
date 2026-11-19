<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        // Required Default Glamping Rooms from PRD
        $rooms = [
            [
                'name' => 'Safari Luxury Suite',
                'category' => 'Deluxe Safari Tent',
                'description' => 'Tenda safari premium dengan deck kayu jati, kasur king-size, kamar mandi dalam berpemanas air, dan panorama lereng pinus langsung.',
                'price_per_night' => 850000,
                'total_stock' => 4,
                'image_path' => 'images/Camp_with_chair.jpg',
            ],
            [
                'name' => 'Forest Glamping Dome',
                'category' => 'Family Glamping Dome',
                'description' => 'Dome geodesic berinsulasi ganda dengan dinding kaca lengkung 180 derajat untuk menatap langit malam dan pegunungan.',
                'price_per_night' => 1250000,
                'total_stock' => 3,
                'image_path' => 'images/Camp_premium.jpg',
            ],
            [
                'name' => 'Alpine Wooden Cabin',
                'category' => 'Romantic Cabin Forest',
                'description' => 'Kabin kayu cedar dengan perapian bioetanol, balkon pribadi di atas kanopi pepohonan, serta bak rendam air hangat luar ruangan.',
                'price_per_night' => 1650000,
                'total_stock' => 2,
                'image_path' => 'images/Camp_cabin.jpg',
            ],
        ];

        foreach ($rooms as $room) {
            DB::table('rooms')->updateOrInsert(
                ['name' => $room['name']],
                array_merge($room, [
                    'updated_at' => now(),
                    'created_at' => now(),
                ])
            );
        }
    }
}
