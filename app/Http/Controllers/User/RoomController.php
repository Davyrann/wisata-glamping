<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Menampilkan katalog kamar glamping terkurasi di dalam dashboard tamu.
 */
class RoomController extends Controller
{
    /**
     * Tampilkan seluruh paket dan kamar glamping yang tersedia untuk reservasi.
     */
    public function __invoke(Request $request): View
    {
        $category = $request->query('category');

        $query = Room::query();

        if (! empty($category)) {
            $query->where('category', $category);
        }

        $rooms = $query->orderBy('price_per_night')->get();
        $categories = Room::distinct()->orderBy('category')->pluck('category');

        return view('user.rooms', [
            'user' => $request->user(),
            'rooms' => $rooms,
            'categories' => $categories,
            'selectedCategory' => $category,
        ]);
    }
}
