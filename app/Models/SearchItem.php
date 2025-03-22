<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\SearchItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $search_id
 * @property string $title
 * @property string $description
 * @property-read Search|null $search
 */
final class SearchItem extends Model
{
    /** @use HasFactory<SearchItemFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'search_id',
        'title',
        'description',
    ];

    /**
     * @return BelongsTo<Search, $this>
     */
    public function search(): BelongsTo
    {
        return $this->belongsTo(Search::class);
    }
}
