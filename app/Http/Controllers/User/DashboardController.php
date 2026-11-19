<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Ringkasan dashboard akun tamu Atara Glamping.
 */
class DashboardController extends Controller
{
    /**
     * Tampilkan antarmuka ringkasan akun tamu dengan status reservasi aktif.
     */
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $latestBooking = Booking::with('room')
            ->where('user_id', $user->id)
            ->latest('created_at')
            ->first();

        $counts = [
            'bookings' => Booking::where('user_id', $user->id)->count(),
            'unpaid' => Booking::where('user_id', $user->id)->where('status', 'unpaid')->count(),
            'cards' => Booking::where('user_id', $user->id)->whereIn('status', ['confirmed', 'checked_in'])->count(),
        ];

        return view('user.dashboard', [
            'user' => $user,
            'latestBooking' => $latestBooking,
            'counts' => $counts,
        ]);
    }
}
