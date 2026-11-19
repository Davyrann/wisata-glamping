<?php

declare(strict_types=1);

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Dashboard operasional untuk Staff Atara Glamping.
 */
class DashboardController extends Controller
{
    /**
     * Tampilkan metrik operasional staf sesuai PRD:
     * sewa hari ini, reservasi aktif, permohonan pembatalan pending, dsb.
     */
    public function __invoke(Request $request): View
    {
        $today = now('Asia/Jakarta')->toDateString();

        $metrics = [
            'today_checkins' => DB::table('bookings')->where('check_in_date', $today)->count(),
            'active_reservations' => DB::table('bookings')->whereIn('status', ['confirmed', 'checked_in'])->count(),
            'pending_cancellations' => DB::table('cancellation_requests')->where('status', 'pending')->count(),
            'total_rooms' => DB::table('rooms')->count(),
        ];

        $recentBookings = DB::table('bookings')
            ->join('rooms', 'rooms.id', '=', 'bookings.room_id')
            ->select('bookings.*', 'rooms.name as room_name')
            ->orderByDesc('bookings.created_at')
            ->limit(5)
            ->get();

        return view('staff.dashboard', [
            'user' => $request->user(),
            'metrics' => $metrics,
            'recentBookings' => $recentBookings,
        ]);
    }
}
