<?php

declare(strict_types=1);

use function Pest\Laravel\get;

test('preparation checklist page loads successfully', function () {
    $response = get(route('preparation.checklist'));

    $response->assertOk();
    $response->assertViewIs('preparation-checklist');
    $response->assertSee('Persiapan kecil, pengalaman alam yang lebih tenang.');
    $response->assertSee('Cetak Checklist');
});

test('preparation checklist contains its groups and interactive controls', function () {
    $response = get(route('preparation.checklist'));

    $response->assertSee('Dokumen & Reservasi');
    $response->assertSee('Pakaian & Perlengkapan Pribadi');
    $response->assertSee('Kesehatan & Kenyamanan');
    $response->assertSee('Gawai & Perlengkapan Tambahan');
    $response->assertSee('id="progress-bar"', false);
    $response->assertSee('id="reset-checklist"', false);
    $response->assertSee('id="print-checklist"', false);
});
