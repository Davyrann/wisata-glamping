<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Artikel edukasi dan panduan wisata Atara Glamping.
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string|null $thumbnail_path
 * @property int $author_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $author
 */
class Article extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'thumbnail_path',
        'author_id',
    ];

    /**
     * Penulis artikel.
     *
     * @return BelongsTo<User, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
