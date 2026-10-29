<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

/**
 * Class LandingController
 *
 * Menangani tampilan halaman utama (landing page) serta halaman transisi
 * untuk modul autentikasi yang masih dalam tahap persiapan.
 */
class LandingController extends Controller
{
    /**
     * Menampilkan landing page publik Atara Glamping.
     *
     * Menyajikan katalog kamar, perlengkapan sewa, panduan reservasi,
     * artikel edukasi, dan informasi kontak.
     */
    public function index(): View
    {
        return view('landing');
    }

    /**
     * Menampilkan halaman error layanan untuk modul autentikasi yang sedang disiapkan.
     */
    public function authUnavailable(): Response
    {
        return response()->view('errors.auth-unavailable', [], 503);
    }
}
