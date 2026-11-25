<?php

declare(strict_types=1);

use App\Models\Article;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

test('user dashboard displays personal 6 month spending chart', function () {
    $user = User::where('email', 'user@demo.test')->first();
    $room = Room::first();

    Booking::create([
        'booking_code' => 'GLAMP-CHT01',
        'user_id' => $user->id,
        'room_id' => $room->id,
        'guest_name' => $user->name,
        'guest_email' => $user->email,
        'guest_phone' => '081234567892',
        'check_in_date' => now()->addDays(4)->toDateString(),
        'check_out_date' => now()->addDays(5)->toDateString(),
        'duration_nights' => 1,
        'room_price' => 850000,
        'has_insurance' => false,
        'insurance_fee' => 0,
        'total_amount' => 850000,
        'status' => 'confirmed',
    ]);

    $this->actingAs($user)->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Pengeluaran 6 Bulan Terakhir')
        ->assertSee('Rp 850.000');
});

test('landing page and article detail page display seeded educational articles', function () {
    $articles = Article::all();

    expect($articles)->toHaveCount(3);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Tips Glamping Nyaman untuk Pemula');

    $first = $articles->first();

    $this->get(route('articles.show', $first->slug))
        ->assertOk()
        ->assertSee($first->title);
});
