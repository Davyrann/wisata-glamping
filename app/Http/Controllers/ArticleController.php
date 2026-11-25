<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\View;

/**
 * Menampilkan halaman baca artikel edukasi wisata glamping.
 */
class ArticleController extends Controller
{
    /**
     * Tampilkan detail satu artikel berdasarkan slug.
     */
    public function show(string $slug): View
    {
        $article = Article::with('author')->where('slug', $slug)->firstOrFail();
        $related = Article::where('id', '!=', $article->id)
            ->latest()
            ->limit(2)
            ->get();

        return view('articles.show', [
            'article' => $article,
            'related' => $related,
        ]);
    }
}
