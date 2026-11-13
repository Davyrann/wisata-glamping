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
    $response->assertSee('id="fasilitas"', false);
    $response->assertSee('id="panduan"', false);
    $response->assertSee('id="kebijakan"', false);
    $response->assertSee('id="cek-reservasi"', false);
    $response->assertSee('id="artikel"', false);
    $response->assertSee('id="kontak"', false);

    // 3 Room types from PRD
    $response->assertSee('Safari Luxury Suite');
    $response->assertSee('Alpine Geodesic Dome');
    $response->assertSee('Bell Tent Pine Retreat');

    // Included Glamping facilities from PRD
    $response->assertSee('Perapian Batu & Kayu Bakar', false);
    $response->assertSee('Pancuran Air Panas 24 Jam');
    $response->assertSee('Listrik 24 Jam & Wi-Fi Area', false);
    $response->assertSee('Sarapan Alpine & Racikan Teh', false);

    // Financial rules from PRD
    $response->assertSee('Bebas Biaya Deposit');
    $response->assertSee('Asuransi Pembatalan (Flat Rp 25.000)');
    $response->assertSee('14.00 WIB');
    $response->assertSee('12.00 WIB');

    // 3 Articles from PRD
    $response->assertSee('Tips Memilih Tenda untuk Pemula di Cuaca Dingin Pegunungan');
    $response->assertSee('Checklist Alat Camping Esensial untuk Glamping Nyaman Bersama Keluarga');
    $response->assertSee('Glamping Minimalis: Mendekap Keheningan Alam Tanpa Mengorbankan Kenyamanan');
});

test('all referenced images exist in public images directory', function () {
    $images = [
        'Camp_premium.jpg',
        'Camp_with_chair.jpg',
        'Camp_from_above.jpg',
        'High_standart_camp.jpg',
        'Bed_photo.jpg',
    ];

    foreach ($images as $image) {
        expect(file_exists(public_path('images/'.$image)))->toBeTrue(
            "Gambar public/images/{$image} wajib tersedia."
        );
    }
});

test('login route renders login view with 200 OK', function () {
    $response = get(route('login'));

    $response->assertOk();
    $response->assertViewIs('auth.login');
    $response->assertSee('Masuk ke Akun');
    $response->assertSee(route('home'));
});

test('rendered views do not contain forbidden em dash characters', function () {
    $landingHtml = get(route('home'))->getContent();
    $loginHtml = get(route('login'))->getContent();

    expect(str_contains($landingHtml, '—'))->toBeFalse('Landing page tidak boleh memuat karakter em dash (—).');
    expect(str_contains($loginHtml, '—'))->toBeFalse('Error page tidak boleh memuat karakter em dash (—).');
});

test('landing page and layout have proper favicon and app icons configured', function () {
    $response = get(route('home'));

    $response->assertSee('favicon.svg');
    $response->assertSee('favicon-32x32.png');
    $response->assertSee('favicon-16x16.png');
    $response->assertSee('apple-touch-icon.png');
    $response->assertSee('favicon.ico');
    $response->assertSee('site.webmanifest');

    expect(file_exists(public_path('favicon.svg')))->toBeTrue();
    expect(file_exists(public_path('favicon.ico')))->toBeTrue();
    expect(file_exists(public_path('favicon-32x32.png')))->toBeTrue();
    expect(file_exists(public_path('favicon-16x16.png')))->toBeTrue();
    expect(file_exists(public_path('apple-touch-icon.png')))->toBeTrue();
    expect(file_exists(public_path('site.webmanifest')))->toBeTrue();
});
