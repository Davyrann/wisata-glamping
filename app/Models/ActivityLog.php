<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class ActivityLog
 *
 * Model untuk mencatat riwayat tindakan administratif dan operasional (audit trail)
 * yang dilakukan oleh Staff atau Admin Atara Glamping.
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $action
 * @property string $description
 * @property string|null $ip_address
 * @property Carbon|null $created_at
 * @property-read User|null $user
 */
class ActivityLog extends Model
{
    use HasFactory;

    /**
     * Nama kolom penanda waktu pembaruan record dimatikan karena
     * tabel activity_logs hanya mengelola catatan created_at.
     */
    public const UPDATED_AT = null;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',
    ];

    /**
     * Relasi ke model User yang melakukan tindakan.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
