<?php

declare(strict_types=1);

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

test('public visitor can check confirmed booking by code and email or phone and see digital card', function () {
    $user = User::where('email', 'user@demo.test')->first();
    $room = Room::first();

    Booking::create([
        'booking_code' => 'GLAMP-PUB01',
        'user_id' => $user->id,
        'room_id' => $room->id,
        'guest_name' => 'Budi Santoso',
        'guest_email' => 'budi@example.test',
        'guest_phone' => '081299998888',
        'check_in_date' => now()->addDays(5)->toDateString(),
        'check_out_date' => now()->addDays(7)->toDateString(),
        'duration_nights' => 2,
        'room_price' => $room->price_per_night,
        'has_insurance' => false,
        'insurance_fee' => 0,
        'total_amount' => $room->price_per_night * 2,
        'status' => 'confirmed',
    ]);

    $this->get(route('booking.check', [
        'booking_code' => 'glamp-pub01',
        'contact' => 'budi@example.test',
    ]))
        ->assertOk()
        ->assertSee('GLAMP-PUB01')
        ->assertSee('Terkonfirmasi')
        ->assertSee('ATARA · KARTU MENGINAP');

    $this->get(route('booking.check', [
        'booking_code' => 'GLAMP-PUB01',
        'contact' => '081299998888',
    ]))
        ->assertOk()
        ->assertSee('Budi Santoso')
        ->assertSee('ATARA · KARTU MENGINAP');
});

test('public booking check rejects mismatched contact and hides card for unpaid booking', function () {
    $user = User::where('email', 'user@demo.test')->first();
    $room = Room::first();

    Booking::create([
        'booking_code' => 'GLAMP-UNP01',
        'user_id' => $user->id,
        'room_id' => $room->id,
        'guest_name' => 'Sari',
        'guest_email' => 'sari@example.test',
        'guest_phone' => '081200011122',
        'check_in_date' => now()->addDays(5)->toDateString(),
        'check_out_date' => now()->addDays(6)->toDateString(),
        'duration_nights' => 1,
        'room_price' => $room->price_per_night,
        'has_insurance' => false,
        'insurance_fee' => 0,
        'total_amount' => $room->price_per_night,
        'status' => 'unpaid',
    ]);

    $this->get(route('booking.check', [
        'booking_code' => 'GLAMP-UNP01',
        'contact' => 'wrong@example.test',
    ]))
        ->assertOk()
        ->assertSee('Reservasi tidak ditemukan');

    $this->get(route('booking.check', [
        'booking_code' => 'GLAMP-UNP01',
        'contact' => 'sari@example.test',
    ]))
        ->assertOk()
        ->assertSee('Menunggu Pembayaran')
        ->assertDontSee('ATARA · KARTU MENGINAP');
});
