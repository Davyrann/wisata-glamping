<?php

declare(strict_types=1);

use App\Models\ActivityLog;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
    $this->admin = User::where('email', 'admin@demo.test')->first();
});

test('only admin can open account management and activity logs', function () {
    $staff = User::where('email', 'staff@demo.test')->first();
    $guest = User::where('email', 'user@demo.test')->first();

    $this->get(route('admin.users.index'))->assertRedirect(route('login'));
    $this->actingAs($staff)->get(route('admin.users.index'))->assertForbidden();
    $this->actingAs($guest)->get(route('admin.logs'))->assertForbidden();
    $this->actingAs($this->admin)->get(route('admin.users.index'))->assertOk()->assertSee('Manajemen Akun');
    $this->actingAs($this->admin)->get(route('admin.logs'))->assertOk()->assertSee('Log Aktivitas');
});

test('admin can create a staff account and the action is logged', function () {
    $this->actingAs($this->admin)->post(route('admin.users.store'), [
        'name' => 'Staff Baru',
        'email' => 'baru@demo.test',
        'phone' => '081200000000',
        'role' => 'staff',
        'password' => 'Rahasia#2026',
        'password_confirmation' => 'Rahasia#2026',
    ])->assertRedirect(route('admin.users.index'));

    $created = User::where('email', 'baru@demo.test')->first();
    expect($created->role)->toBe('staff')
        ->and(Hash::check('Rahasia#2026', $created->password))->toBeTrue();
    expect(ActivityLog::where('action', 'user_created')->where('user_id', $this->admin->id)->exists())->toBeTrue();
});

test('account creation validates role, duplicate email, and password', function () {
    $this->actingAs($this->admin)->post(route('admin.users.store'), [
        'name' => 'X',
        'email' => 'staff@demo.test',
        'role' => 'superuser',
        'password' => 'short',
        'password_confirmation' => 'other',
    ])->assertSessionHasErrors(['email', 'role', 'password']);
});

test('admin can update an account and password stays when left blank', function () {
    $guest = User::where('email', 'user@demo.test')->first();
    $oldHash = $guest->password;

    $this->actingAs($this->admin)->put(route('admin.users.update', $guest), [
        'name' => 'Tamu Diubah',
        'email' => 'user@demo.test',
        'role' => 'staff',
        'password' => '',
        'password_confirmation' => '',
    ])->assertRedirect(route('admin.users.index'));

    $guest->refresh();
    expect($guest->name)->toBe('Tamu Diubah')->and($guest->role)->toBe('staff')->and($guest->password)->toBe($oldHash);
});

test('admin cannot demote or delete their own account', function () {
    $this->actingAs($this->admin)->put(route('admin.users.update', $this->admin), [
        'name' => $this->admin->name,
        'email' => $this->admin->email,
        'role' => 'user',
    ])->assertSessionHasErrors('role');

    $this->actingAs($this->admin)->delete(route('admin.users.destroy', $this->admin))->assertSessionHasErrors('delete');
    expect($this->admin->fresh()->role)->toBe('admin');
});

test('admin can delete an account without active bookings but not one with active bookings', function () {
    $free = User::factory()->create(['role' => 'user']);
    $busy = User::factory()->create(['role' => 'user']);
    $roomId = DB::table('rooms')->value('id');

    DB::table('bookings')->insert([
        'booking_code' => 'GLAMP-ADM-01', 'user_id' => $busy->id, 'room_id' => $roomId,
        'guest_name' => 'Busy', 'guest_email' => $busy->email, 'guest_phone' => '0812',
        'check_in_date' => now()->addDays(10)->toDateString(), 'check_out_date' => now()->addDays(12)->toDateString(),
        'duration_nights' => 2, 'room_price' => 400000, 'has_insurance' => false, 'insurance_fee' => 0,
        'total_amount' => 800000, 'status' => 'confirmed', 'created_at' => now(), 'updated_at' => now(),
    ]);

    $this->actingAs($this->admin)->delete(route('admin.users.destroy', $busy))->assertSessionHasErrors('delete');
    expect(User::find($busy->id))->not->toBeNull();

    $this->actingAs($this->admin)->delete(route('admin.users.destroy', $free))->assertRedirect(route('admin.users.index'));
    expect(User::find($free->id))->toBeNull();
    expect(ActivityLog::where('action', 'user_deleted')->exists())->toBeTrue();
});

test('account list can be searched and filtered by role', function () {
    $this->actingAs($this->admin)->get(route('admin.users.index', ['role' => 'staff']))
        ->assertOk()->assertSee('staff@demo.test')->assertDontSee('user@demo.test');

    $this->actingAs($this->admin)->get(route('admin.users.index', ['search' => 'Tamu Demo']))
        ->assertOk()->assertSee('user@demo.test')->assertDontSee('staff@demo.test');
});

test('activity log page filters by action and date range', function () {
    ActivityLog::create(['user_id' => $this->admin->id, 'action' => 'login', 'description' => 'Masuk sistem uji', 'ip_address' => '127.0.0.1']);
    ActivityLog::create(['user_id' => $this->admin->id, 'action' => 'user_created', 'description' => 'Buat akun uji', 'ip_address' => '127.0.0.1']);

    $this->actingAs($this->admin)->get(route('admin.logs', ['action' => 'login']))
        ->assertOk()->assertSee('Masuk sistem uji')->assertDontSee('Buat akun uji');

    $this->actingAs($this->admin)->get(route('admin.logs', ['from' => '2030-01-01']))
        ->assertOk()->assertSee('Tidak ada log ditemukan');

    $this->actingAs($this->admin)->get(route('admin.logs', ['from' => '2026-12-31', 'to' => '2026-01-01']))
        ->assertSessionHasErrors('to');
});

test('admin dashboard shows revenue and pending cancellation metrics', function () {
    $this->actingAs($this->admin)->get(route('admin.dashboard'))
        ->assertOk()->assertSee('PENDAPATAN (DUMMY)')->assertSee('PEMBATALAN PENDING');
});
