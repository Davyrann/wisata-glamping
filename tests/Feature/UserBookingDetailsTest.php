<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

/** Buat booking data uji tanpa mengubah data demo sebenarnya. */
function createTicketBooking(User $user, string $code, string $status): void
{
    $roomId = DB::table('rooms')->insertGetId([
        'name' => 'Forest Test Room', 'category' => 'Dome', 'description' => 'Kamar uji',
        'price_per_night' => 500000, 'total_stock' => 2, 'created_at' => now(), 'updated_at' => now(),
    ]);
    DB::table('bookings')->insert([
        'booking_code' => $code, 'user_id' => $user->id, 'room_id' => $roomId,
        'guest_name' => $user->name, 'guest_email' => $user->email,
        'guest_phone' => '081234567890', 'check_in_date' => now()->addDays(7)->toDateString(),
        'check_out_date' => now()->addDays(8)->toDateString(), 'duration_nights' => 1,
        'room_price' => 500000, 'has_insurance' => true, 'insurance_fee' => 25000,
        'total_amount' => 525000, 'status' => $status, 'created_at' => now(), 'updated_at' => now(),
    ]);
}

test('guest cannot view booking detail or cards', function () {
    $this->get(route('dashboard.bookings.show', 'GLAMP-NONE'))->assertRedirect(route('login'));
    $this->get(route('dashboard.cards'))->assertRedirect(route('login'));
});

test('user cannot open detail booking owned by another user', function () {
    $owner = User::factory()->create(['role' => 'user']);
    $stranger = User::factory()->create(['role' => 'user']);
    createTicketBooking($owner, 'GLAMP-SECRET-1', 'confirmed');
    $this->actingAs($stranger)->get(route('dashboard.bookings.show', 'GLAMP-SECRET-1'))->assertNotFound();
});

test('confirmed booking detail displays digital card', function () {
    $user = User::factory()->create(['role' => 'user']);
    createTicketBooking($user, 'GLAMP-CARD-1', 'confirmed');
    $this->actingAs($user)->get(route('dashboard.bookings.show', 'GLAMP-CARD-1'))
        ->assertOk()->assertSee('GLAMP-CARD-1')->assertSee('Kartu digital Anda')->assertSee('Rp 525.000');
});

test('unpaid booking cannot display digital card', function () {
    $user = User::factory()->create(['role' => 'user']);
    createTicketBooking($user, 'GLAMP-UNPAID-1', 'unpaid');
    $this->actingAs($user)->get(route('dashboard.bookings.show', 'GLAMP-UNPAID-1'))
        ->assertOk()->assertSee('Kartu digital belum tersedia')->assertDontSee('ATARA · KARTU MENGINAP');
});

test('cards page only lists confirmed and checked in booking from current user', function () {
    $user = User::factory()->create(['role' => 'user']);
    $other = User::factory()->create(['role' => 'user']);
    createTicketBooking($user, 'GLAMP-YES-1', 'confirmed');
    createTicketBooking($user, 'GLAMP-NO-1', 'unpaid');
    createTicketBooking($other, 'GLAMP-OTHER-1', 'checked_in');
    $this->actingAs($user)->get(route('dashboard.cards'))
        ->assertOk()->assertSee('GLAMP-YES-1')->assertDontSee('GLAMP-NO-1')->assertDontSee('GLAMP-OTHER-1');
});
