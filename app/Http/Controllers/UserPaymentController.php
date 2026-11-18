<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/** Simulasi pembayaran sandbox tanpa transaksi uang nyata. */
class UserPaymentController extends Controller
{
    /** Tampilkan hanya transaksi belum dibayar milik akun ini. */
    public function index(Request $request): View
    {
        $bookings = DB::table('bookings')->join('rooms','rooms.id','=','bookings.room_id')
            ->where('bookings.user_id', $request->user()->id)->where('bookings.status','unpaid')
            ->select('bookings.*','rooms.name as room_name')->orderByDesc('bookings.created_at')->paginate(10);
        return view('dashboard.payments', ['bookings' => $bookings, 'user' => $request->user()]);
    }

    /** Pindahkan unpaid ke confirmed secara atomik (dummy sandbox). */
    public function pay(Request $request, string $code): RedirectResponse
    {
        DB::transaction(function () use ($request, $code): void {
            $booking = DB::table('bookings')->where('booking_code', $code)
                ->where('user_id', $request->user()->id)->lockForUpdate()->first();
            abort_unless($booking, 404);
            if ($booking->status !== 'unpaid') {
                throw ValidationException::withMessages(['payment' => 'Pesanan ini tidak dapat dibayar lagi.']);
            }
            if ($booking->check_in_date < now('Asia/Jakarta')->toDateString()) {
                throw ValidationException::withMessages(['payment' => 'Tanggal check-in sudah berlalu. Hubungi staf untuk bantuan.']);
            }
            DB::table('bookings')->where('id', $booking->id)->update(['status'=>'confirmed','updated_at'=>now()]);
        });
        return redirect()->route('dashboard.bookings.show', $code)->with('status','Pembayaran dummy berhasil, pesanan dikonfirmasi.');
    }

    /** Batalkan transaksi unpaid tanpa refund karena belum dibayar. */
    public function discard(Request $request, string $code): RedirectResponse
    {
        DB::transaction(function () use ($request, $code): void {
            $booking = DB::table('bookings')->where('booking_code',$code)
                ->where('user_id',$request->user()->id)->lockForUpdate()->first();
            abort_unless($booking,404);
            if ($booking->status !== 'unpaid') {
                throw ValidationException::withMessages(['payment' => 'Hanya pesanan belum dibayar yang dapat dibatalkan langsung.']);
            }
            DB::table('bookings')->where('id',$booking->id)->update(['status'=>'cancelled','updated_at'=>now()]);
        });
        return redirect()->route('dashboard.bookings', ['tab'=>'cancelled'])->with('status','Pesanan belum dibayar telah dibatalkan.');
    }
}
