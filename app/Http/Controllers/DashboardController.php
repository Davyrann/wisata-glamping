<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * Class DashboardController
 *
 * Menampilkan halaman ringkasan akun dan reservasi aktif bagi pengguna yang terautentikasi.
 */
class DashboardController extends Controller
{
    /**
     * Menampilkan antarmuka ringkasan dashboard akun pengguna.
     */
    public function index(): View
    {
        $user = Auth::user();

        return view('dashboard', [
            'user' => $user,
        ]);
    }
}
