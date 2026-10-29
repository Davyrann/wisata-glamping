<?php

declare(strict_types=1);

use function Pest\Laravel\get;

test('landing page loads successfully with 200 OK', function () {
    $response = get(route('home'));

    $response->assertOk();
    $response->assertViewIs('landing');
    $response->assertSee('Atara Glamping');
    $response->assertSee('Kenyamanan Kabin Mewah di Pelukan Rimba Pegunungan');
});

test('landing page contains all required sections from PRD', function () {
    $response = get(route('home'));

    // Section anchors
    $response->assertSee('id="kamar"', false);
    $response->assertSee('id="alat"', false);
    $response->assertSee('id="panduan"', false);
    $response->assertSee('id="kebijakan"', false);
    $response->assertSee('id="artikel"', false);
    $response->assertSee('id="kontak"', false);

    // 3 Room types from PRD
    $response->assertSee('Safari Luxury Suite');
    $response->assertSee('Alpine Geodesic Dome');
    $response->assertSee('Bell Tent Pine Retreat');

    // Equipment add-ons from PRD
    $response->assertSee('Cooking Set & Kompor Ultralight', false);
    $response->assertSee('Kursi Reclining & Meja Kayu', false);
    $response->assertSee('Lentera Retro Ambient LED');
    $response->assertSee('Sleeping Bag Bulu Angsa & Matras', false);

    // Financial rules from PRD
    $response->assertSee('Deposit Jaminan Kerusakan (Rp 50.000)');
    $response->assertSee('Asuransi Pembatalan (Rp 25.000 Opsional)');
    $response->assertSee('14.00 WIB');
    $response->assertSee('12.00 WIB');

    // 3 Articles from PRD
    $response->assertSee('Tips Memilih Tenda untuk Pemula di Cuaca Dingin Pegunungan');
    $response->assertSee('Checklist Alat Camping Esensial untuk Glamping Nyaman Bersama Keluarga');
    $response->assertSee('Glamping Minimalis: Mendekap Keheningan Alam Tanpa Mengorbankan Kenyamanan');
});

test('all referenced images exist in public images directory', function () {
    $images = [
        'Mountain_View.jpg',
        'Night_Camp.jpg',
        'Moutanin_with_Snow_on_top.jpg',
        'Mountain_with_Campfire.jpg',
        'Marshmellow.jpg',
    ];

    foreach ($images as $image) {
        expect(file_exists(public_path('images/'.$image)))->toBeTrue(
            "Gambar public/images/{$image} wajib tersedia."
        );
    }
});

test('login route redirects to or displays 503 service unavailable error page', function () {
    $response = get(route('login'));

    $response->assertStatus(503);
    $response->assertViewIs('errors.auth-unavailable');
    $response->assertSee('Gerbang Masuk Sedang Disiapkan');
    $response->assertSee(route('home'));
});

test('rendered views do not contain forbidden em dash characters', function () {
    $landingHtml = get(route('home'))->getContent();
    $loginHtml = get(route('login'))->getContent();

    expect(str_contains($landingHtml, '—'))->toBeFalse('Landing page tidak boleh memuat karakter em dash (—).');
    expect(str_contains($loginHtml, '—'))->toBeFalse('Error page tidak boleh memuat karakter em dash (—).');
});
