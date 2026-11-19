<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Dashboard administrator sistem Atara Glamping.
 */
class DashboardController extends Controller
{
    /**
     * Tampilkan metrik manajemen admin: total akun, log aktivitas staf, kamar, dan pembukuan.
     */
    public function __invoke(Request $request): View
    {
        $metrics = [
            'total_users' => User::where('role', 'user')->count(),
            'total_staff' => User::where('role', 'staff')->count(),
            'total_rooms' => DB::table('rooms')->count(),
            'total_bookings' => DB::table('bookings')->count(),
        ];

        $recentLogs = ActivityLog::with('user')->orderByDesc('created_at')->limit(8)->get();

        return view('admin.dashboard', [
            'user' => $request->user(),
            'metrics' => $metrics,
            'recentLogs' => $recentLogs,
        ]);
    }
}
