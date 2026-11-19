<?php

declare(strict_types=1);

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

test('guest cannot access reservation page or submit booking', function () {
    $room = DB::table('rooms')->first();

    $this->get(route('dashboard.rooms.book', $room->id))->assertRedirect(route('login'));
    $this->post(route('dashboard.rooms.reserve', $room->id), [])->assertRedirect(route('login'));
});

test('user can open reservation form with room data and prefilled user info', function () {
    $user = User::where('email', 'user@demo.test')->first();
    $room = DB::table('rooms')->first();

    $this->actingAs($user)->get(route('dashboard.rooms.book', $room->id))
        ->assertOk()
        ->assertSee('Formulir Reservasi Glamping')
        ->assertSee($room->name)
        ->assertSee($user->name)
        ->assertSee($user->email);
});

test('user can create reservation with insurance and gets redirected to payments', function () {
    $user = User::where('email', 'user@demo.test')->first();
    $room = DB::table('rooms')->where('name', 'Safari Luxury Suite')->first();

    $checkIn = now('Asia/Jakarta')->addDays(5)->toDateString();
    $checkOut = now('Asia/Jakarta')->addDays(7)->toDateString();

    $response = $this->actingAs($user)->post(route('dashboard.rooms.reserve', $room->id), [
        'guest_name' => 'Tamu Demo',
        'guest_email' => 'user@demo.test',
        'guest_phone' => '081234567890',
        'check_in_date' => $checkIn,
        'check_out_date' => $checkOut,
        'has_insurance' => '1',
    ]);

    $response->assertRedirect(route('dashboard.payments'));
    $response->assertSessionHas('status');

    $booking = DB::table('bookings')->where('user_id', $user->id)->first();

    expect($booking)->not->toBeNull();
    expect($booking->status)->toBe('unpaid');
    expect($booking->duration_nights)->toBe(2);
    expect((bool) $booking->has_insurance)->toBeTrue();
    expect((float) $booking->insurance_fee)->toBe(25000.0);
    // (850.000 * 2) + 25.000 = 1.725.000
    expect((float) $booking->total_amount)->toBe(1725000.0);
    expect($booking->booking_code)->toStartWith('GLAMP-');
});

test('user can create reservation without insurance', function () {
    $user = User::where('email', 'user@demo.test')->first();
    $room = DB::table('rooms')->where('name', 'Safari Luxury Suite')->first();

    $checkIn = now('Asia/Jakarta')->addDays(10)->toDateString();
    $checkOut = now('Asia/Jakarta')->addDays(11)->toDateString();

    $response = $this->actingAs($user)->post(route('dashboard.rooms.reserve', $room->id), [
        'guest_name' => 'Tamu Demo',
        'guest_email' => 'user@demo.test',
        'guest_phone' => '081234567890',
        'check_in_date' => $checkIn,
        'check_out_date' => $checkOut,
    ]);

    $response->assertRedirect(route('dashboard.payments'));

    $booking = DB::table('bookings')->where('user_id', $user->id)->first();
    expect($booking)->not->toBeNull();
    expect((bool) $booking->has_insurance)->toBeFalse();
    expect((float) $booking->insurance_fee)->toBe(0.0);
    expect((float) $booking->total_amount)->toBe(850000.0);
});

test('reservation is rejected when room stock is fully booked for requested dates', function () {
    $user = User::where('email', 'user@demo.test')->first();
    // Alpine Wooden Cabin has total_stock = 2
    $room = DB::table('rooms')->where('name', 'Alpine Wooden Cabin')->first();

    $checkIn = now('Asia/Jakarta')->addDays(3)->toDateString();
    $checkOut = now('Asia/Jakarta')->addDays(5)->toDateString();

    // Isi stok penuh (2 booking confirmed)
    for ($i = 1; $i <= $room->total_stock; $i++) {
        DB::table('bookings')->insert([
            'booking_code' => "GLAMP-OCCUPIED-{$i}",
            'user_id' => $user->id,
            'room_id' => $room->id,
            'guest_name' => "Tamu {$i}",
            'guest_email' => "tamu{$i}@test.com",
            'guest_phone' => '08123456789',
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'duration_nights' => 2,
            'room_price' => $room->price_per_night,
            'has_insurance' => false,
            'insurance_fee' => 0,
            'total_amount' => $room->price_per_night * 2,
            'status' => 'confirmed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // Pemesanan ke-3 pada tanggal yang sama harus ditolak karena stok habis
    $response = $this->actingAs($user)->post(route('dashboard.rooms.reserve', $room->id), [
        'guest_name' => 'Tamu Demo',
        'guest_email' => 'user@demo.test',
        'guest_phone' => '081234567890',
        'check_in_date' => $checkIn,
        'check_out_date' => $checkOut,
    ]);

    $response->assertSessionHasErrors('check_in_date');
});

test('checkout date must be after checkin date', function () {
    $user = User::where('email', 'user@demo.test')->first();
    $room = DB::table('rooms')->first();

    $checkIn = now('Asia/Jakarta')->addDays(3)->toDateString();

    $response = $this->actingAs($user)->post(route('dashboard.rooms.reserve', $room->id), [
        'guest_name' => 'Tamu Demo',
        'guest_email' => 'user@demo.test',
        'guest_phone' => '081234567890',
        'check_in_date' => $checkIn,
        'check_out_date' => $checkIn, // check out sama dengan check in (0 malam)
    ]);

    $response->assertSessionHasErrors('check_out_date');
});
