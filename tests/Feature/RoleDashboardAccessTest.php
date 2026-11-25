<?php

declare(strict_types=1);

use App\Models\Room;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

test('guest is redirected to login from all dashboards', function () {
    $this->get(route('dashboard'))->assertRedirect(route('login'));
    $this->get(route('dashboard.rooms'))->assertRedirect(route('login'));
    $this->get(route('staff.dashboard'))->assertRedirect(route('login'));
    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
});

test('user accessing /dashboard receives user dashboard with Role User badge', function () {
    $user = User::where('email', 'user@demo.test')->first();

    $this->actingAs($user)->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Ringkasan akun')
        ->assertSee('Role User: user');
});

test('user can browse glamping rooms catalog in user dashboard', function () {
    $user = User::where('email', 'user@demo.test')->first();

    $this->actingAs($user)->get(route('dashboard.rooms'))
        ->assertOk()
        ->assertSee('Katalog Kamar Glamping')
        ->assertSee('Safari Luxury Suite')
        ->assertSee('Forest Glamping Dome')
        ->assertSee('Alpine Wooden Cabin');

    foreach (Room::all() as $room) {
        expect(file_exists(public_path($room->image_path)))->toBeTrue();
    }
});

test('staff accessing /dashboard is redirected to staff dashboard', function () {
    $staff = User::where('email', 'staff@demo.test')->first();

    $this->actingAs($staff)->get(route('dashboard'))
        ->assertRedirect(route('staff.dashboard'));

    $this->actingAs($staff)->get(route('staff.dashboard'))
        ->assertOk()
        ->assertSee('Dashboard Operasional')
        ->assertSee('CHECK-IN HARI INI');
});

test('admin accessing /dashboard is redirected to admin dashboard', function () {
    $admin = User::where('email', 'admin@demo.test')->first();

    $this->actingAs($admin)->get(route('dashboard'))
        ->assertRedirect(route('admin.dashboard'));

    $this->actingAs($admin)->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Panel Administrator')
        ->assertSee('TOTAL PENGGUNA TAMU');

    $this->actingAs($admin)->get(route('staff.dashboard'))
        ->assertOk()
        ->assertSee('Dashboard Operasional')
        ->assertSee('Role: admin');
});

test('role middleware forbids unauthorized cross-role access', function () {
    $user = User::where('email', 'user@demo.test')->first();
    $staff = User::where('email', 'staff@demo.test')->first();

    // User dilarang membuka panel staff dan admin
    $this->actingAs($user)->get(route('staff.dashboard'))->assertForbidden();
    $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();

    // Staff dilarang membuka panel admin
    $this->actingAs($staff)->get(route('admin.dashboard'))->assertForbidden();
});
