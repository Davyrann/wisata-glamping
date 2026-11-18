<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Menampilkan riwayat booking milik pengguna yang sedang login.
 * Tidak mengubah status maupun data transaksi.
 */
class UserBookingController extends Controller
{
    /**
     * Filter, kelompokkan, dan paginasi reservasi milik user (10 per halaman).
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'tab' => ['nullable', 'in:upcoming,ongoing,completed,cancelled'],
            'search' => ['nullable', 'string', 'max:60'],
            'from' => ['nullable', 'date_format:Y-m-d'],
            'to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:from'],
            'category' => ['nullable', 'string', 'max:100'],
        ]);
        $tab = $filters['tab'] ?? 'upcoming';
        $today = now('Asia/Jakarta')->toDateString();

        $owned = static function () use ($request) {
            return DB::table('bookings')->where('bookings.user_id', $request->user()->id);
        };

        $counts = [
            'upcoming' => $owned()->whereIn('status', ['unpaid', 'confirmed'])
                ->where('check_in_date', '>=', $today)->count(),
            'ongoing' => $owned()->where(function ($query) use ($today): void {
                $query->where('status', 'checked_in')
                    ->orWhere(function ($inner) use ($today): void {
                        $inner->where('status', 'confirmed')
                            ->where('check_in_date', '<', $today)
                            ->where('check_out_date', '>', $today);
                    });
            })->count(),
            'completed' => $owned()->where('status', 'completed')->count(),
            'cancelled' => $owned()->where('status', 'cancelled')->count(),
        ];

        $query = $owned()->join('rooms', 'rooms.id', '=', 'bookings.room_id')
            ->select('bookings.*', 'rooms.name as room_name', 'rooms.category as room_category', 'rooms.image_path as room_image');

        switch ($tab) {
            case 'upcoming':
                $query->whereIn('bookings.status', ['unpaid', 'confirmed'])
                    ->where('bookings.check_in_date', '>=', $today);
                break;
            case 'ongoing':
                $query->where(function ($builder) use ($today): void {
                    $builder->where('bookings.status', 'checked_in')
                        ->orWhere(function ($inner) use ($today): void {
                            $inner->where('bookings.status', 'confirmed')
                                ->where('bookings.check_in_date', '<', $today)
                                ->where('bookings.check_out_date', '>', $today);
                        });
                });
                break;
            case 'completed':
                $query->where('bookings.status', 'completed');
                break;
            default:
                $query->where('bookings.status', 'cancelled');
        }

        if (!empty($filters['search'])) {
            $query->where('bookings.booking_code', 'like', '%'.addcslashes($filters['search'], '%_\\').'%');
        }
        if (!empty($filters['from'])) {
            $query->whereDate('bookings.check_in_date', '>=', $filters['from']);
        }
        if (!empty($filters['to'])) {
            $query->whereDate('bookings.check_out_date', '<=', $filters['to']);
        }
        if (!empty($filters['category'])) {
            $query->where('rooms.category', $filters['category']);
        }

        $bookings = $query->orderByDesc('bookings.created_at')
            ->orderByDesc('bookings.id')->paginate(10)->withQueryString();
        $categories = DB::table('rooms')->whereIn('id', $owned()->select('room_id'))
            ->distinct()->orderBy('category')->pluck('category');

        return view('dashboard.bookings', [
            'user' => $request->user(),
            'bookings' => $bookings,
            'counts' => $counts,
            'tab' => $tab,
            'categories' => $categories,
            'filters' => $filters,
        ]);
    }

    /**
     * Tampilkan detail sebuah reservasi milik user yang sedang login.
     * Booking orang lain selalu 404, termasuk saat kode valid.
     */
    public function show(Request $request, string $code): View
    {
        $booking = DB::table('bookings')
            ->join('rooms', 'rooms.id', '=', 'bookings.room_id')
            ->where('bookings.user_id', $request->user()->id)
            ->where('bookings.booking_code', $code)
            ->select('bookings.*', 'rooms.name as room_name', 'rooms.category as room_category', 'rooms.image_path as room_image')
            ->first();

        abort_unless($booking, 404);

        $cancellation = DB::table('cancellation_requests')->where('booking_id', $booking->id)
            ->where('user_id', $request->user()->id)->orderByDesc('id')->first();

        return view('dashboard.booking-detail', [
            'user' => $request->user(),
            'booking' => $booking,
            'cancellation' => $cancellation,
        ]);
    }

    /** Tampilkan hanya kartu milik user dengan status confirmed atau checked_in. */
    public function cards(Request $request): View
    {
        $cards = DB::table('bookings')
            ->join('rooms', 'rooms.id', '=', 'bookings.room_id')
            ->where('bookings.user_id', $request->user()->id)
            ->whereIn('bookings.status', ['confirmed', 'checked_in'])
            ->select('bookings.*', 'rooms.name as room_name')
            ->orderBy('bookings.check_in_date')
            ->get();

        return view('dashboard.cards', ['user' => $request->user(), 'cards' => $cards]);
    }
}
