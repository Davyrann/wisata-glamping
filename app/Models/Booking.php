<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Model transaksi reservasi kamar glamping Atara.
 *
 * @property int $id
 * @property string $booking_code
 * @property int|null $user_id
 * @property int $room_id
 * @property string $guest_name
 * @property string $guest_email
 * @property string $guest_phone
 * @property Carbon $check_in_date
 * @property Carbon $check_out_date
 * @property int $duration_nights
 * @property float $room_price
 * @property bool $has_insurance
 * @property float $insurance_fee
 * @property float $total_amount
 * @property string $status
 * @property Carbon|null $check_in_at
 * @property Carbon|null $check_out_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Booking extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'booking_code',
        'user_id',
        'room_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'check_in_date',
        'check_out_date',
        'duration_nights',
        'room_price',
        'has_insurance',
        'insurance_fee',
        'total_amount',
        'status',
        'check_in_at',
        'check_out_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'check_in_date' => 'date',
            'check_out_date' => 'date',
            'duration_nights' => 'integer',
            'room_price' => 'decimal:2',
            'has_insurance' => 'boolean',
            'insurance_fee' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'check_in_at' => 'datetime',
            'check_out_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke unit kamar yang dipesan.
     *
     * @return BelongsTo<Room, $this>
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Relasi ke pemilik reservasi (user terdaftar).
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Riwayat pengajuan pembatalan untuk reservasi ini.
     *
     * @return HasMany<CancellationRequest, $this>
     */
    public function cancellationRequests(): HasMany
    {
        return $this->hasMany(CancellationRequest::class);
    }

    /**
     * Permohonan pembatalan paling mutakhir.
     *
     * @return HasOne<CancellationRequest, $this>
     */
    public function latestCancellationRequest(): HasOne
    {
        return $this->hasOne(CancellationRequest::class)->latestOfMany();
    }

    /**
     * Nama kamar (accessor untuk kompatibilitas tampilan).
     */
    public function getRoomNameAttribute(): string
    {
        return $this->room?->name ?? '';
    }

    /**
     * Kategori kamar (accessor untuk kompatibilitas tampilan).
     */
    public function getRoomCategoryAttribute(): string
    {
        return $this->room?->category ?? '';
    }

    /**
     * Gambar kamar (accessor untuk kompatibilitas tampilan).
     */
    public function getRoomImageAttribute(): ?string
    {
        return $this->room?->image_path;
    }

    /**
     * Scope untuk menyaring reservasi berdasarkan tab navigasi (upcoming, ongoing, completed, cancelled).
     *
     * @param  Builder<Booking>  $query
     * @return Builder<Booking>
     */
    public function scopeInTab(Builder $query, string $tab, string $today): Builder
    {
        return match ($tab) {
            'upcoming' => $query->whereIn('status', ['unpaid', 'confirmed', 'cancellation_requested'])
                ->where('check_in_date', '>=', $today),
            'ongoing' => $query->where(function (Builder $builder) use ($today): void {
                $builder->where('status', 'checked_in')
                    ->orWhere(function (Builder $inner) use ($today): void {
                        $inner->whereIn('status', ['confirmed', 'cancellation_requested'])
                            ->where('check_in_date', '<', $today)
                            ->where('check_out_date', '>', $today);
                    });
            }),
            'completed' => $query->where('status', 'completed'),
            'cancelled' => $query->where('status', 'cancelled'),
            default => $query->where('status', 'cancelled'),
        };
    }
}
