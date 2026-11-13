<?php

declare(strict_types=1);

use App\Models\ActivityLog;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

uses(RefreshDatabase::class);

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\seed;

beforeEach(function () {
    seed(DatabaseSeeder::class);
    RateLimiter::clear('user@demo.test|127.0.0.1');
    RateLimiter::clear('staff@demo.test|127.0.0.1');
    RateLimiter::clear('admin@demo.test|127.0.0.1');
    RateLimiter::clear('invalid@demo.test|127.0.0.1');
});

test('login page renders with 200 OK and expected UI elements from DESIGN.md', function () {
    $response = get(route('login'));

    $response->assertOk();
    $response->assertViewIs('auth.login');

    // Branding & Header
    $response->assertSee('Atara Glamping');
    $response->assertSee('Masuk ke Akun');
    $response->assertSee('Akses reservasi dan detail menginap Anda.');

    // Split photo & caption (DESIGN.md §7.7)
    $response->assertSee('Camp_premium.jpg');
    $response->assertSee('Lanskap Pagi Hari');
    $response->assertSee('1.620 mdpl');

    // Form fields
    $response->assertSee('Alamat Email');
    $response->assertSee('Kata Sandi');
    $response->assertSee('Ingat saya di perangkat ini');
    $response->assertSee('Lupa kata sandi?');
    $response->assertSee('Cek booking tanpa login');
});

test('login page provides quick demo accounts selector for testing', function () {
    $response = get(route('login'));

    $response->assertSee('user@demo.test');
    $response->assertSee('staff@demo.test');
    $response->assertSee('admin@demo.test');
});

test('guest user can authenticate successfully with valid credentials', function () {
    $response = post(route('login.store'), [
        'email' => 'user@demo.test',
        'password' => 'User#2026',
    ]);

    $response->assertRedirect(route('dashboard'));
    assertAuthenticated();

    $user = Auth::user();
    expect($user)->not->toBeNull();
    expect($user->email)->toBe('user@demo.test');
    expect($user->role)->toBe('user');
});

test('staff authentication records activity log entry', function () {
    $response = post(route('login.store'), [
        'email' => 'staff@demo.test',
        'password' => 'Staff#2026',
    ]);

    $response->assertRedirect(route('dashboard'));
    assertAuthenticated();

    $staff = User::where('email', 'staff@demo.test')->first();
    expect($staff)->not->toBeNull();

    $log = ActivityLog::where('user_id', $staff->id)
        ->where('action', 'login')
        ->first();

    expect($log)->not->toBeNull();
    expect($log->description)->toContain('Staff Operasional');
});

test('admin authentication records activity log entry', function () {
    $response = post(route('login.store'), [
        'email' => 'admin@demo.test',
        'password' => 'Admin#2026',
    ]);

    $response->assertRedirect(route('dashboard'));
    assertAuthenticated();

    $admin = User::where('email', 'admin@demo.test')->first();
    expect($admin)->not->toBeNull();

    $log = ActivityLog::where('user_id', $admin->id)
        ->where('action', 'login')
        ->first();

    expect($log)->not->toBeNull();
    expect($log->description)->toContain('Administrator Glamping');
});

test('authentication fails with invalid credentials and sets validation error', function () {
    $response = post(route('login.store'), [
        'email' => 'user@demo.test',
        'password' => 'WrongPassword#123',
    ]);

    $response->assertSessionHasErrors('email');
    assertGuest();
});

test('rate limiter blocks login after 5 consecutive failed attempts', function () {
    $key = 'brute@demo.test|127.0.0.1';
    RateLimiter::clear($key);

    for ($i = 0; $i < 5; $i++) {
        $response = post(route('login.store'), [
            'email' => 'brute@demo.test',
            'password' => 'WrongPassword',
        ]);
        $response->assertSessionHasErrors('email');
    }

    // Attempt ke-6 harus terblokir oleh rate limiter
    $blockedResponse = post(route('login.store'), [
        'email' => 'brute@demo.test',
        'password' => 'WrongPassword',
    ]);

    $blockedResponse->assertSessionHasErrors('email');
    expect(session('errors')->first('email'))->toContain('Terlalu banyak percobaan');
});

test('authenticated user can logout and session is invalidated', function () {
    $user = User::where('email', 'user@demo.test')->first();
    actingAs($user);
    assertAuthenticatedAs($user);

    $response = post(route('logout'));

    $response->assertRedirect(route('home'));
    $response->assertSessionHas('status');
    assertGuest();
});

test('authenticated staff logout records activity log entry', function () {
    $staff = User::where('email', 'staff@demo.test')->first();
    actingAs($staff);

    $response = post(route('logout'));

    $response->assertRedirect(route('home'));
    assertGuest();

    $logoutLog = ActivityLog::where('user_id', $staff->id)
        ->where('action', 'logout')
        ->first();

    expect($logoutLog)->not->toBeNull();
});

test('authenticated users are redirected away from login page', function () {
    $user = User::where('email', 'user@demo.test')->first();

    $response = actingAs($user)->get(route('login'));

    $response->assertRedirect(route('dashboard'));
});

test('dashboard requires authentication', function () {
    $response = get(route('dashboard'));

    $response->assertRedirect(route('login'));
});

test('dashboard displays plain html with role user text for authenticated user', function () {
    $user = User::where('email', 'user@demo.test')->first();

    $response = actingAs($user)->get(route('dashboard'));

    $response->assertOk();
    $response->assertSee('Role User: user');
});

test('rendered login and dashboard views contain zero forbidden em dash characters', function () {
    $loginHtml = get(route('login'))->getContent();

    $user = User::where('email', 'user@demo.test')->first();
    $dashboardHtml = actingAs($user)->get(route('dashboard'))->getContent();

    expect(str_contains($loginHtml, '—'))->toBeFalse('Halaman login tidak boleh memuat karakter em dash (—).');
    expect(str_contains($dashboardHtml, '—'))->toBeFalse('Halaman dashboard tidak boleh memuat karakter em dash (—).');
});
