<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/** Pengajuan pembatalan untuk disetujui atau ditolak oleh Staff. */
class UserCancellationController extends Controller
{
    /** Ajukan satu permohonan pending untuk booking confirmed milik pengguna. */
    public function store(Request $request, string $code): RedirectResponse
    {
        $data = $request->validate(['reason'=>['required','string','min:10','max:2000']]);
        DB::transaction(function () use ($request,$code,$data): void {
            $booking = DB::table('bookings')->where('booking_code',$code)
                ->where('user_id',$request->user()->id)->lockForUpdate()->first();
            abort_unless($booking,404);
            if ($booking->status !== 'confirmed') {
                throw ValidationException::withMessages(['reason'=>'Hanya booking terkonfirmasi yang bisa diajukan pembatalannya.']);
            }
            $today = Carbon::now('Asia/Jakarta')->startOfDay();
            $checkIn = Carbon::parse($booking->check_in_date,'Asia/Jakarta')->startOfDay();
            if ($checkIn->lessThanOrEqualTo($today)) {
                throw ValidationException::withMessages(['reason'=>'Pengajuan harus sebelum tanggal check-in.']);
            }
            if (DB::table('cancellation_requests')->where('booking_id',$booking->id)->where('status','pending')->exists()) {
                throw ValidationException::withMessages(['reason'=>'Sudah ada pengajuan pembatalan yang menunggu persetujuan.']);
            }
            $days = (int) $today->diffInDays($checkIn);
            $percent = $booking->has_insurance ? ($days > 3 ? 100 : 50) : 0;
            $roomSubtotal = (float) $booking->room_price * (int) $booking->duration_nights;
            DB::table('cancellation_requests')->insert([
                'booking_id'=>$booking->id,'user_id'=>$request->user()->id,
                'reason'=>$data['reason'],'refund_percentage'=>$percent,
                'refund_amount'=>round($roomSubtotal*$percent/100,2),
                'status'=>'pending','created_at'=>now(),'updated_at'=>now(),
            ]);
        });
        return redirect()->route('dashboard.bookings.show',$code)->with('status','Permohonan pembatalan sudah dikirim dan menunggu keputusan staf.');
    }
}
