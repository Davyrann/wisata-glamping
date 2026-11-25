<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest can view registration page and register as user role only', function () {
    $this->get(route('register'))
        ->assertOk()
        ->assertSee('Daftar Akun Tamu');

    $this->post(route('register.store'), [
        'name' => 'Tamu Baru',
        'email' => 'tamu.baru@example.test',
        'phone' => '081234567899',
        'role' => 'admin',
        'password' => 'Rahasia#2026',
        'password_confirmation' => 'Rahasia#2026',
    ])->assertRedirect(route('dashboard'));

    $created = User::where('email', 'tamu.baru@example.test')->first();

    expect($created)->not->toBeNull()
        ->and($created->role)->toBe('user');
    $this->assertAuthenticatedAs($created);
});

test('registration validates duplicate email and password confirmation', function () {
    User::factory()->create(['email' => 'dup@example.test']);

    $this->post(route('register.store'), [
        'name' => 'X',
        'email' => 'dup@example.test',
        'password' => 'short',
        'password_confirmation' => 'mismatch',
    ])->assertSessionHasErrors(['email', 'password']);
});
