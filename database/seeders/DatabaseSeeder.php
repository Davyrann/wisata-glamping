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
                'image_path' => 'images/High_standart_camp.jpg',
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

        $authorId = User::where('email', 'staff@demo.test')->value('id')
            ?? User::where('email', 'admin@demo.test')->value('id');

        if ($authorId !== null) {
            $articles = [
                [
                    'title' => 'Tips Glamping Nyaman untuk Pemula',
                    'slug' => 'tips-glamping-nyaman-untuk-pemula',
                    'thumbnail_path' => 'images/Camp_premium.jpg',
                    'content' => "Memulai pengalaman glamping di kawasan pegunungan memerlukan persiapan ringan namun tepat sasaran.\n\nPertama, pilih tipe kamar yang sesuai dengan kebutuhan rombongan dan suhu malam hari. Tenda kanvas berinsulasi atau kabin kayu membantu menjaga kehangatan tanpa mengurangi suasana alam.\n\nKedua, datanglah lebih awal menjelang waktu check-in pukul 14.00 WIB agar Anda sempat menikmati suasana hutan pinus sebelum kabut sore turun.\n\nKetiga, manfaatkan opsi asuransi pembatalan saat reservasi apabila rencana perjalanan Anda masih fleksibel.",
                ],
                [
                    'title' => 'Checklist Perlengkapan Liburan Alam',
                    'slug' => 'checklist-perlengkapan-liburan-alam',
                    'thumbnail_path' => 'images/Camp_from_above.jpg',
                    'content' => "Meski unit glamping telah menyediakan tempat tidur dan fasilitas utama, beberapa barang pribadi tetap penting untuk dibawa.\n\nSiapkan jaket tahan angin, kaus kaki hangat, alas kaki anti-selip untuk jalur hutan, obat-obatan pribadi, serta botol minum isi ulang.\n\nJangan lupa menyimpan kode booking dan kartu digital QR di ponsel Anda agar proses serah terima kamar saat tiba berjalan cepat dan lancar.",
                ],
                [
                    'title' => 'Glamping Minimalis: Menikmati Alam Tanpa Ribet',
                    'slug' => 'glamping-minimalis-menikmati-alam-tanpa-ribet',
                    'thumbnail_path' => 'images/High_standart_camp.jpg',
                    'content' => "Glamping minimalis hadir bagi wisatawan yang ingin menjauh dari hiruk pikuk kota tanpa harus repot mendirikan tenda atau membawa peralatan berkemah berat.\n\nDengan desain ruang yang fungsional, pencahayaan hangat, serta akses langsung ke udara pegunungan 1.620 mdpl, Anda dapat berfokus pada istirahat berkualitas dan kebersamaan bersama keluarga.",
                ],
            ];

            foreach ($articles as $article) {
                DB::table('articles')->updateOrInsert(
                    ['slug' => $article['slug']],
                    array_merge($article, [
                        'author_id' => $authorId,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ])
                );
            }
        }
    }
}
