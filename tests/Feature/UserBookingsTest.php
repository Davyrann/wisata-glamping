<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

/** Buat kamar dan transaksi khusus untuk menguji isolasi data user. */
function makeBookingFor(User $user, string $code, string $status = 'confirmed'): void
{
    $roomId = DB::table('rooms')->insertGetId([
        'name' => 'Safari Test', 'category' => 'Deluxe',
        'description' => 'Unit test', 'price_per_night' => 500000,
        'total_stock' => 2, 'created_at' => now(), 'updated_at' => now(),
    ]);
    DB::table('bookings')->insert([
        'booking_code' => $code, 'user_id' => $user->id, 'room_id' => $roomId,
        'guest_name' => $user->name, 'guest_email' => $user->email,
        'guest_phone' => '081234567890',
        'check_in_date' => now('Asia/Jakarta')->addDays(7)->toDateString(),
        'check_out_date' => now('Asia/Jakarta')->addDays(8)->toDateString(),
        'duration_nights' => 1, 'room_price' => 500000,
        'has_insurance' => false, 'insurance_fee' => 0, 'total_amount' => 500000,
        'status' => $status, 'created_at' => now(), 'updated_at' => now(),
    ]);
}

test('guest must sign in to see user bookings', function () {
    $this->get(route('dashboard.bookings'))->assertRedirect(route('login'));
});

test('user sees only their bookings', function () {
    $a = User::factory()->create(['role' => 'user']);
    $b = User::factory()->create(['role' => 'user']);
    makeBookingFor($a, 'GLAMP-OWN-01');
    makeBookingFor($b, 'GLAMP-OTHER-01');

    $this->actingAs($a)->get(route('dashboard.bookings'))
        ->assertOk()->assertSee('GLAMP-OWN-01')->assertDontSee('GLAMP-OTHER-01');
});

test('empty list is shown when no booking exists', function () {
    $user = User::factory()->create(['role' => 'user']);
    $this->actingAs($user)->get(route('dashboard.bookings'))
        ->assertOk()->assertSee('Tidak ada pesanan ditemukan');
});

test('filter search by booking code', function () {
    $user = User::factory()->create(['role' => 'user']);
    makeBookingFor($user, 'GLAMP-FIND-01');
    makeBookingFor($user, 'GLAMP-HIDE-02');
    $this->actingAs($user)->get(route('dashboard.bookings', ['search' => 'FIND']))
        ->assertOk()->assertSee('GLAMP-FIND-01')->assertDontSee('GLAMP-HIDE-02');
});
