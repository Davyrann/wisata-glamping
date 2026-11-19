<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CancellationRequest;
use App\Models\Room;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Mengelola seluruh daur hidup reservasi tamu Atara Glamping:
 * pembuatan booking, riwayat pesanan, kartu digital, pembayaran sandbox, dan pengajuan pembatalan.
 */
class BookingController extends Controller
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

        $ownedQuery = Booking::query()->where('user_id', $request->user()->id);

        $counts = [
            'upcoming' => (clone $ownedQuery)->inTab('upcoming', $today)->count(),
            'ongoing' => (clone $ownedQuery)->inTab('ongoing', $today)->count(),
            'completed' => (clone $ownedQuery)->inTab('completed', $today)->count(),
            'cancelled' => (clone $ownedQuery)->inTab('cancelled', $today)->count(),
        ];

        $query = (clone $ownedQuery)->with('room')->inTab($tab, $today);

        if (! empty($filters['search'])) {
            $query->where('booking_code', 'like', '%'.addcslashes($filters['search'], '%_\\').'%');
        }
        if (! empty($filters['from'])) {
            $query->whereDate('check_in_date', '>=', $filters['from']);
        }
        if (! empty($filters['to'])) {
            $query->whereDate('check_out_date', '<=', $filters['to']);
        }
        if (! empty($filters['category'])) {
            $query->whereHas('room', function ($q) use ($filters): void {
                $q->where('category', $filters['category']);
            });
        }

        $bookings = $query->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $categories = Room::whereIn('id', (clone $ownedQuery)->select('room_id'))
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('user.bookings.index', [
            'user' => $request->user(),
            'bookings' => $bookings,
            'counts' => $counts,
            'tab' => $tab,
            'categories' => $categories,
            'filters' => $filters,
        ]);
    }

    /**
     * Tampilkan antarmuka formulir pemesanan kamar glamping baru di dalam dashboard.
     */
    public function create(Request $request, int $roomId): View
    {
        $room = Room::findOrFail($roomId);
        $allRooms = Room::orderBy('price_per_night')->get();

        return view('user.reservations.create', [
            'user' => $request->user(),
            'room' => $room,
            'allRooms' => $allRooms,
        ]);
    }

    /**
     * Proses pembuatan reservasi baru dengan validasi konkurensi stok kamar secara real-time.
     */
    public function store(Request $request, int $roomId): RedirectResponse
    {
        $today = now('Asia/Jakarta')->toDateString();

        $data = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_email' => ['required', 'email', 'max:255'],
            'guest_phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+() .-]*$/'],
            'check_in_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:'.$today],
            'check_out_date' => ['required', 'date_format:Y-m-d', 'after:check_in_date'],
            'has_insurance' => ['nullable', 'boolean'],
        ]);

        $bookingCode = '';

        DB::transaction(function () use ($request, $roomId, $data, &$bookingCode): void {
            $room = Room::where('id', $roomId)->lockForUpdate()->firstOrFail();

            // Validasi ketersediaan stok kamar pada rentang tanggal booking (concurrency lock)
            $activeCount = Booking::where('room_id', $room->id)
                ->whereIn('status', ['unpaid', 'confirmed', 'cancellation_requested', 'checked_in'])
                ->where('check_in_date', '<', $data['check_out_date'])
                ->where('check_out_date', '>', $data['check_in_date'])
                ->count();

            if ($activeCount >= (int) $room->total_stock) {
                throw ValidationException::withMessages([
                    'check_in_date' => 'Maaf, kamar '.$room->name.' sudah penuh pada rentang tanggal yang dipilih. Silakan pilih tanggal atau tipe kamar lain.',
                ]);
            }

            $checkIn = Carbon::parse($data['check_in_date'], 'Asia/Jakarta')->startOfDay();
            $checkOut = Carbon::parse($data['check_out_date'], 'Asia/Jakarta')->startOfDay();
            $durationNights = (int) $checkIn->diffInDays($checkOut);

            if ($durationNights < 1) {
                throw ValidationException::withMessages([
                    'check_out_date' => 'Durasi sewa minimal 1 malam.',
                ]);
            }

            $roomPrice = (float) $room->price_per_night;
            $hasInsurance = $request->boolean('has_insurance');
            $insuranceFee = $hasInsurance ? 25000.00 : 0.00;
            $totalAmount = ($roomPrice * $durationNights) + $insuranceFee;

            do {
                $bookingCode = 'GLAMP-'.strtoupper(Str::random(6));
            } while (Booking::where('booking_code', $bookingCode)->exists());

            Booking::create([
                'booking_code' => $bookingCode,
                'user_id' => $request->user()->id,
                'room_id' => $room->id,
                'guest_name' => $data['guest_name'],
                'guest_email' => $data['guest_email'],
                'guest_phone' => $data['guest_phone'],
                'check_in_date' => $data['check_in_date'],
                'check_out_date' => $data['check_out_date'],
                'duration_nights' => $durationNights,
                'room_price' => $roomPrice,
                'has_insurance' => $hasInsurance,
                'insurance_fee' => $insuranceFee,
                'total_amount' => $totalAmount,
                'status' => 'unpaid',
            ]);
        });

        return redirect()->route('dashboard.payments')
            ->with('status', 'Reservasi berhasil dibuat dengan kode '.$bookingCode.'! Silakan selesaikan simulasi pembayaran di bawah.');
    }

    /**
     * Tampilkan detail sebuah reservasi milik user yang sedang login.
     * Booking orang lain selalu 404, termasuk saat kodenya valid.
     */
    public function show(Request $request, string $code): View
    {
        $booking = Booking::with(['room', 'latestCancellationRequest'])
            ->where('user_id', $request->user()->id)
            ->where('booking_code', $code)
            ->firstOrFail();

        return view('user.bookings.show', [
            'user' => $request->user(),
            'booking' => $booking,
            'cancellation' => $booking->latestCancellationRequest,
        ]);
    }

    /**
     * Tampilkan hanya kartu menginap digital milik user dengan status confirmed atau checked_in.
     */
    public function cards(Request $request): View
    {
        $cards = Booking::with('room')
            ->where('user_id', $request->user()->id)
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->orderBy('check_in_date')
            ->get();

        return view('user.cards.index', [
            'user' => $request->user(),
            'cards' => $cards,
        ]);
    }

    /**
     * Tampilkan transaksi belum dibayar (unpaid) milik akun pengguna saat ini.
     */
    public function payments(Request $request): View
    {
        $bookings = Booking::with('room')
            ->where('user_id', $request->user()->id)
            ->where('status', 'unpaid')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('user.payments.index', [
            'bookings' => $bookings,
            'user' => $request->user(),
        ]);
    }

    /**
     * Pindahkan pesanan unpaid ke confirmed secara atomik (dummy sandbox),
     * dengan pengecekan stok ketersediaan kamar pada rentang tanggal tersebut.
     */
    public function pay(Request $request, string $code): RedirectResponse
    {
        DB::transaction(function () use ($request, $code): void {
            $booking = Booking::where('booking_code', $code)
                ->where('user_id', $request->user()->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($booking->status !== 'unpaid') {
                throw ValidationException::withMessages(['payment' => 'Pesanan ini tidak dapat dibayar lagi.']);
            }

            if ($booking->check_in_date->lt(now('Asia/Jakarta')->startOfDay())) {
                throw ValidationException::withMessages(['payment' => 'Tanggal check-in sudah berlalu. Hubungi staf untuk bantuan.']);
            }

            // Validasi konkurensi stok kamar pada rentang tanggal pemesanan
            $room = Room::where('id', $booking->room_id)->lockForUpdate()->first();
            $totalStock = $room ? (int) $room->total_stock : 1;

            $activeCount = Booking::where('room_id', $booking->room_id)
                ->where('id', '!=', $booking->id)
                ->whereIn('status', ['confirmed', 'checked_in'])
                ->where('check_in_date', '<', $booking->check_out_date)
                ->where('check_out_date', '>', $booking->check_in_date)
                ->count();

            if ($activeCount >= $totalStock) {
                throw ValidationException::withMessages([
                    'payment' => 'Unit kamar sudah habis terpesan pada tanggal ini. Hubungi staf atau pilih tanggal lain.',
                ]);
            }

            $booking->update([
                'status' => 'confirmed',
            ]);
        });

        return redirect()->route('dashboard.bookings.show', $code)
            ->with('status', 'Pembayaran dummy berhasil, pesanan dikonfirmasi.');
    }

    /**
     * Batalkan transaksi unpaid tanpa refund karena belum ada pembayaran.
     */
    public function discard(Request $request, string $code): RedirectResponse
    {
        DB::transaction(function () use ($request, $code): void {
            $booking = Booking::where('booking_code', $code)
                ->where('user_id', $request->user()->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($booking->status !== 'unpaid') {
                throw ValidationException::withMessages(['payment' => 'Hanya pesanan belum dibayar yang dapat dibatalkan langsung.']);
            }

            $booking->update([
                'status' => 'cancelled',
            ]);
        });

        return redirect()->route('dashboard.bookings', ['tab' => 'cancelled'])
            ->with('status', 'Pesanan belum dibayar telah dibatalkan.');
    }

    /**
     * Ajukan permohonan pembatalan untuk booking confirmed milik pengguna.
     * Mengubah status pesanan menjadi cancellation_requested sesuai state machine PRD.
     */
    public function cancellation(Request $request, string $code): RedirectResponse
    {
        $data = $request->validate([
            'reason' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        DB::transaction(function () use ($request, $code, $data): void {
            $booking = Booking::where('booking_code', $code)
                ->where('user_id', $request->user()->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($booking->status !== 'confirmed') {
                throw ValidationException::withMessages([
                    'reason' => 'Hanya booking terkonfirmasi yang bisa diajukan pembatalannya.',
                ]);
            }

            $today = Carbon::now('Asia/Jakarta')->startOfDay();
            $checkIn = Carbon::parse($booking->check_in_date, 'Asia/Jakarta')->startOfDay();

            if ($checkIn->lessThanOrEqualTo($today)) {
                throw ValidationException::withMessages([
                    'reason' => 'Pengajuan harus sebelum tanggal check-in.',
                ]);
            }

            if ($booking->cancellationRequests()->where('status', 'pending')->exists()) {
                throw ValidationException::withMessages([
                    'reason' => 'Sudah ada pengajuan pembatalan yang menunggu persetujuan.',
                ]);
            }

            $days = (int) $today->diffInDays($checkIn);
            $percent = $booking->has_insurance ? ($days > 3 ? 100 : 50) : 0;
            $roomSubtotal = (float) $booking->room_price * (int) $booking->duration_nights;

            CancellationRequest::create([
                'booking_id' => $booking->id,
                'user_id' => $request->user()->id,
                'reason' => $data['reason'],
                'refund_percentage' => $percent,
                'refund_amount' => round($roomSubtotal * $percent / 100, 2),
                'status' => 'pending',
            ]);

            // Transisi status sesuai diagram lifecycle PRD: confirmed -> cancellation_requested
            $booking->update([
                'status' => 'cancellation_requested',
            ]);
        });

        return redirect()->route('dashboard.bookings.show', $code)
            ->with('status', 'Permohonan pembatalan sudah dikirim dan menunggu keputusan staf operasional.');
    }
}
