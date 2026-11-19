<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\CancellationRequest;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('booking eloquent model has proper relationships and accessors', function () {
    $user = User::factory()->create(['role' => 'user']);
    $room = Room::create([
        'name' => 'Starlight Sky Dome',
        'category' => 'Sky Dome',
        'description' => 'Kamar kubah panorama bintang.',
        'price_per_night' => 750000.00,
        'total_stock' => 3,
        'image_path' => 'images/Camp_premium.jpg',
    ]);

    $booking = Booking::create([
        'booking_code' => 'GLAMP-TEST01',
        'user_id' => $user->id,
        'room_id' => $room->id,
        'guest_name' => $user->name,
        'guest_email' => $user->email,
        'guest_phone' => '081234567890',
        'check_in_date' => now('Asia/Jakarta')->addDays(5)->toDateString(),
        'check_out_date' => now('Asia/Jakarta')->addDays(7)->toDateString(),
        'duration_nights' => 2,
        'room_price' => 750000.00,
        'has_insurance' => true,
        'insurance_fee' => 25000.00,
        'total_amount' => 1525000.00,
        'status' => 'confirmed',
    ]);

    $cancellation = CancellationRequest::create([
        'booking_id' => $booking->id,
        'user_id' => $user->id,
        'reason' => 'Perubahan rencana perjalanan kerja.',
        'refund_percentage' => 100,
        'refund_amount' => 1500000.00,
        'status' => 'pending',
    ]);

    // Relasi
    expect($booking->room->id)->toBe($room->id)
        ->and($booking->user->id)->toBe($user->id)
        ->and($room->bookings)->toHaveCount(1)
        ->and($user->bookings)->toHaveCount(1)
        ->and($booking->cancellationRequests)->toHaveCount(1)
        ->and($booking->latestCancellationRequest->id)->toBe($cancellation->id)
        ->and($cancellation->booking->id)->toBe($booking->id)
        ->and($cancellation->user->id)->toBe($user->id);

    // Accessors
    expect($booking->room_name)->toBe('Starlight Sky Dome')
        ->and($booking->room_category)->toBe('Sky Dome')
        ->and($booking->room_image)->toBe('images/Camp_premium.jpg');
});

test('scopeInTab groups booking lifecycle accurately without duplication', function () {
    $user = User::factory()->create(['role' => 'user']);
    $room = Room::create([
        'name' => 'Standard Dome',
        'category' => 'Dome',
        'description' => 'Test',
        'price_per_night' => 300000,
        'total_stock' => 5,
    ]);

    $today = now('Asia/Jakarta')->toDateString();

    // 1. Upcoming booking (future check-in, confirmed)
    Booking::create([
        'booking_code' => 'GLAMP-UPCOMING',
        'user_id' => $user->id,
        'room_id' => $room->id,
        'guest_name' => 'Upcoming Guest',
        'guest_email' => 'up@test.com',
        'guest_phone' => '0811111111',
        'check_in_date' => now('Asia/Jakarta')->addDays(3)->toDateString(),
        'check_out_date' => now('Asia/Jakarta')->addDays(5)->toDateString(),
        'duration_nights' => 2,
        'room_price' => 300000,
        'has_insurance' => false,
        'insurance_fee' => 0,
        'total_amount' => 600000,
        'status' => 'confirmed',
    ]);

    // 2. Ongoing booking (checked_in)
    Booking::create([
        'booking_code' => 'GLAMP-ONGOING',
        'user_id' => $user->id,
        'room_id' => $room->id,
        'guest_name' => 'Ongoing Guest',
        'guest_email' => 'on@test.com',
        'guest_phone' => '0811111112',
        'check_in_date' => now('Asia/Jakarta')->subDay()->toDateString(),
        'check_out_date' => now('Asia/Jakarta')->addDay()->toDateString(),
        'duration_nights' => 2,
        'room_price' => 300000,
        'has_insurance' => false,
        'insurance_fee' => 0,
        'total_amount' => 600000,
        'status' => 'checked_in',
    ]);

    // 3. Completed booking
    Booking::create([
        'booking_code' => 'GLAMP-COMPLETED',
        'user_id' => $user->id,
        'room_id' => $room->id,
        'guest_name' => 'Completed Guest',
        'guest_email' => 'done@test.com',
        'guest_phone' => '0811111113',
        'check_in_date' => now('Asia/Jakarta')->subDays(5)->toDateString(),
        'check_out_date' => now('Asia/Jakarta')->subDays(3)->toDateString(),
        'duration_nights' => 2,
        'room_price' => 300000,
        'has_insurance' => false,
        'insurance_fee' => 0,
        'total_amount' => 600000,
        'status' => 'completed',
    ]);

    // 4. Cancelled booking
    Booking::create([
        'booking_code' => 'GLAMP-CANCELLED',
        'user_id' => $user->id,
        'room_id' => $room->id,
        'guest_name' => 'Cancelled Guest',
        'guest_email' => 'cancel@test.com',
        'guest_phone' => '0811111114',
        'check_in_date' => now('Asia/Jakarta')->addDays(1)->toDateString(),
        'check_out_date' => now('Asia/Jakarta')->addDays(2)->toDateString(),
        'duration_nights' => 1,
        'room_price' => 300000,
        'has_insurance' => false,
        'insurance_fee' => 0,
        'total_amount' => 300000,
        'status' => 'cancelled',
    ]);

    $baseQuery = Booking::where('user_id', $user->id);

    expect((clone $baseQuery)->inTab('upcoming', $today)->pluck('booking_code')->all())
        ->toEqual(['GLAMP-UPCOMING'])
        ->and((clone $baseQuery)->inTab('ongoing', $today)->pluck('booking_code')->all())
        ->toEqual(['GLAMP-ONGOING'])
        ->and((clone $baseQuery)->inTab('completed', $today)->pluck('booking_code')->all())
        ->toEqual(['GLAMP-COMPLETED'])
        ->and((clone $baseQuery)->inTab('cancelled', $today)->pluck('booking_code')->all())
        ->toEqual(['GLAMP-CANCELLED']);
});
