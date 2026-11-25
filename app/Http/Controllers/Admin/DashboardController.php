<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Booking;
use App\Models\CancellationRequest;
use App\Models\Room;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Dashboard administrator sistem Atara Glamping.
 */
class DashboardController extends Controller
{
    /**
     * Tampilkan metrik manajemen admin: akun, reservasi, pendapatan,
     * pembatalan menunggu, sebaran status, dan log aktivitas terbaru.
     */
    public function __invoke(Request $request): View
    {
        $revenueStatuses = ['confirmed', 'checked_in', 'completed'];

        $metrics = [
            'total_users' => User::where('role', 'user')->count(),
            'total_staff' => User::where('role', 'staff')->count(),
            'total_rooms' => Room::count(),
            'total_bookings' => Booking::count(),
            'revenue' => (float) Booking::whereIn('status', $revenueStatuses)->sum('total_amount'),
            'pending_cancellations' => CancellationRequest::where('status', 'pending')->count(),
        ];

        $statusCounts = Booking::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.dashboard', [
            'user' => $request->user(),
            'metrics' => $metrics,
            'statusCounts' => $statusCounts,
            'recentLogs' => ActivityLog::with('user')->orderByDesc('created_at')->orderByDesc('id')->limit(8)->get(),
        ]);
    }
}
