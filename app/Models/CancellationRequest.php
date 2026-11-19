<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Model pengajuan pembatalan reservasi beransuransi.
 *
 * @property int $id
 * @property int $booking_id
 * @property int $user_id
 * @property string $reason
 * @property int $refund_percentage
 * @property float $refund_amount
 * @property string $status
 * @property int|null $reviewed_by
 * @property Carbon|null $reviewed_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class CancellationRequest extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'booking_id',
        'user_id',
        'reason',
        'refund_percentage',
        'refund_amount',
        'status',
        'reviewed_by',
        'reviewed_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'refund_percentage' => 'integer',
            'refund_amount' => 'decimal:2',
            'reviewed_at' => 'datetime',
        ];
    }

    /**
     * Reservasi yang diajukan pembatalannya.
     *
     * @return BelongsTo<Booking, $this>
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Pengguna yang mengajukan permohonan.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Staf yang meninjau permohonan.
     *
     * @return BelongsTo<User, $this>
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
