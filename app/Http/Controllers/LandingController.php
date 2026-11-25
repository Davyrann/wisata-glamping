<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;

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
        $articles = Schema::hasTable('articles')
            ? Article::query()->latest()->limit(3)->get()
            : collect();

        if ($articles->isEmpty()) {
            $articles = collect([
                (object) [
                    'title' => 'Tips Memilih Tenda untuk Pemula di Cuaca Dingin Pegunungan',
                    'slug' => null,
                    'thumbnail_path' => 'images/Camp_premium.jpg',
                    'content' => 'Mengenal ketebalan kain kanvas, pengaturan ventilasi sirkulasi udara guna mencegah kondensasi kabut, serta trik mengunci pasak di lereng perbukitan berangin.',
                ],
                (object) [
                    'title' => 'Checklist Alat Camping Esensial untuk Glamping Nyaman Bersama Keluarga',
                    'slug' => null,
                    'thumbnail_path' => 'images/Camp_from_above.jpg',
                    'content' => 'Panduan barang bawaan krusial mulai dari pakaian hangat berlapis, lampu lentera portabel, perlengkapan seduh minuman hangat, hingga kotak pertolongan pertama.',
                ],
                (object) [
                    'title' => 'Glamping Minimalis: Mendekap Keheningan Alam Tanpa Mengorbankan Kenyamanan',
                    'slug' => null,
                    'thumbnail_path' => 'images/High_standart_camp.jpg',
                    'content' => 'Bagaimana perpaduan arsitektur ramah lingkungan dan pelayanan hangat memungkinkan manusia modern melepaskan lelah batin dan menyatu dengan semesta.',
                ],
            ]);
        }

        return view('landing', [
            'articles' => $articles,
        ]);
    }
}
