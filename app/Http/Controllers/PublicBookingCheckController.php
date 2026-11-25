<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Pencarian publik status reservasi dan kartu digital tanpa login.
 */
class PublicBookingCheckController extends Controller
{
    /**
     * Cari reservasi berdasarkan kode booking dan email atau nomor telepon tamu.
     */
    public function __invoke(Request $request): View
    {
        $booking = null;
        $searched = $request->hasAny(['booking_code', 'contact']);
        $filters = ['booking_code' => '', 'contact' => ''];

        if ($searched) {
            $validated = $request->validate([
                'booking_code' => ['required', 'string', 'max:40'],
                'contact' => ['required', 'string', 'max:120'],
            ]);

            $code = strtoupper(trim($validated['booking_code']));
            $contact = trim($validated['contact']);
            $filters = ['booking_code' => $code, 'contact' => $contact];

            $booking = Booking::with('room')
                ->where('booking_code', $code)
                ->where(function ($query) use ($contact): void {
                    $query->whereRaw('LOWER(guest_email) = ?', [strtolower($contact)])
                        ->orWhere('guest_phone', $contact);
                })
                ->first();
        }

        return view('public.booking-check', [
            'booking' => $booking,
            'searched' => $searched,
            'filters' => $filters,
        ]);
    }
}
