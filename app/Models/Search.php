<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\SearchFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $category
 * @property string $level
 * @property string $details
 * @property string $hash
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read SearchItem[] $items
 */
final class Search extends Model
{
    /** @use HasFactory<SearchFactory> */
    use HasFactory;

    protected $fillable = [
        'category',
        'level',
        'details',
    ];

    protected $casts = [
        'results' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function boot(): void
    {
        parent::boot();
        self::saving(static function (self $model) {
            $model->hash = md5($model->category.$model->level.$model->details);
        });
    }

    /**
     * @return HasMany<SearchItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(SearchItem::class);
    }
}
