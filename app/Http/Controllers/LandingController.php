<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

/**
 * Class LandingController
 *
 * Menangani tampilan halaman utama (landing page) publik Atara Glamping.
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
}
