<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

uses(RefreshDatabase::class);

test('database has all 6 core tables required by PRD', function () {
    $tables = [
        'users',
        'rooms',
        'bookings',
        'cancellation_requests',
        'articles',
        'activity_logs',
    ];

    foreach ($tables as $table) {
        expect(Schema::hasTable($table))->toBeTrue("Table {$table} must exist in the database.");
    }
});

test('users table has all required columns from PRD', function () {
    $columns = ['id', 'name', 'email', 'password', 'phone', 'role', 'created_at', 'updated_at'];

    foreach ($columns as $column) {
        expect(Schema::hasColumn('users', $column))->toBeTrue("Column users.{$column} must exist.");
    }
});

test('rooms table has all required columns from PRD', function () {
    $columns = [
        'id',
        'name',
        'category',
        'description',
        'price_per_night',
        'total_stock',
        'image_path',
        'created_at',
        'updated_at',
    ];

    foreach ($columns as $column) {
        expect(Schema::hasColumn('rooms', $column))->toBeTrue("Column rooms.{$column} must exist.");
    }
});

test('bookings table has all required columns from PRD', function () {
    $columns = [
        'id',
        'booking_code',
        'user_id',
        'room_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'check_in_date',
        'check_out_date',
        'duration_nights',
        'room_price',
        'has_insurance',
        'insurance_fee',
        'total_amount',
        'status',
        'created_at',
        'updated_at',
    ];

    foreach ($columns as $column) {
        expect(Schema::hasColumn('bookings', $column))->toBeTrue("Column bookings.{$column} must exist.");
    }
});

test('cancellation_requests table has all required columns from PRD', function () {
    $columns = [
        'id',
        'booking_id',
        'user_id',
        'reason',
        'refund_percentage',
        'refund_amount',
        'status',
        'reviewed_by',
        'reviewed_at',
        'created_at',
        'updated_at',
    ];

    foreach ($columns as $column) {
        expect(Schema::hasColumn('cancellation_requests', $column))->toBeTrue("Column cancellation_requests.{$column} must exist.");
    }
});

test('articles table has all required columns from PRD', function () {
    $columns = [
        'id',
        'title',
        'slug',
        'content',
        'thumbnail_path',
        'author_id',
        'created_at',
        'updated_at',
    ];

    foreach ($columns as $column) {
        expect(Schema::hasColumn('articles', $column))->toBeTrue("Column articles.{$column} must exist.");
    }
});

test('activity_logs table has all required columns from PRD', function () {
    $columns = [
        'id',
        'user_id',
        'action',
        'description',
        'ip_address',
        'created_at',
    ];

    foreach ($columns as $column) {
        expect(Schema::hasColumn('activity_logs', $column))->toBeTrue("Column activity_logs.{$column} must exist.");
    }
});

test('database seeder creates required demo accounts from PRD', function () {
    $this->seed();

    $admin = User::where('email', 'admin@demo.test')->first();
    expect($admin)->not->toBeNull();
    expect($admin->role)->toBe('admin');

    $staff = User::where('email', 'staff@demo.test')->first();
    expect($staff)->not->toBeNull();
    expect($staff->role)->toBe('staff');

    $user = User::where('email', 'user@demo.test')->first();
    expect($user)->not->toBeNull();
    expect($user->role)->toBe('user');
});
