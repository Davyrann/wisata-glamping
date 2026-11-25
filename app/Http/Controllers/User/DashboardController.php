<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * Ringkasan dashboard akun tamu Atara Glamping.
 */
class DashboardController extends Controller
{
    /**
     * Tampilkan antarmuka ringkasan akun tamu dengan status reservasi aktif
     * serta grafik riwayat sewa/pengeluaran 6 bulan terakhir.
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

        $now = Carbon::now('Asia/Jakarta')->startOfMonth();
        $startMonth = $now->copy()->subMonths(5);

        $bookingsInRange = Booking::query()
            ->where('user_id', $user->id)
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', $startMonth->copy()->utc())
            ->get(['total_amount', 'created_at']);

        $grouped = $bookingsInRange->groupBy(fn (Booking $b): string => $b->created_at->timezone('Asia/Jakarta')->format('Y-m'));

        $monthlySpending = [];
        for ($i = 0; $i < 6; $i++) {
            $month = $startMonth->copy()->addMonths($i);
            $key = $month->format('Y-m');
            $items = $grouped->get($key, collect());
            $monthlySpending[] = [
                'label' => $month->locale('id')->translatedFormat('M Y'),
                'count' => $items->count(),
                'amount' => (float) $items->sum('total_amount'),
            ];
        }

        $maxMonthlySpend = max(1.0, (float) collect($monthlySpending)->max('amount'));

        return view('user.dashboard', [
            'user' => $user,
            'latestBooking' => $latestBooking,
            'counts' => $counts,
            'monthlySpending' => $monthlySpending,
            'maxMonthlySpend' => $maxMonthlySpend,
        ]);
    }
}
