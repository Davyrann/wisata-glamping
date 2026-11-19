<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Model kamar / tipe akomodasi glamping Atara.
 *
 * @property int $id
 * @property string $name
 * @property string $category
 * @property string $description
 * @property float $price_per_night
 * @property int $total_stock
 * @property string|null $image_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Room extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'category',
        'description',
        'price_per_night',
        'total_stock',
        'image_path',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price_per_night' => 'decimal:2',
            'total_stock' => 'integer',
        ];
    }

    /**
     * Relasi ke seluruh reservasi pada kamar ini.
     *
     * @return HasMany<Booking, $this>
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
