<?php

namespace App\Models;

use App\Models\Traits\CanBeScoped;
use App\Models\Traits\HasPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use phpseclib\Math\BigInteger;

/**
 * Class Product
 *
 * @package App\Models
 *
 * @property integer id
 * @property string name
 * @property string slug
 * @property string excerpt
 * @property string formattedPrice
 *
 */
class Product extends Model
{
    use CanBeScoped, HasPrice;

    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return bool
     */
    public function inStock(): bool
    {
        return $this->stockCount() > 0;
    }

    /**
     * @return int
     */
    public function stockCount(): int
    {
        return $this->variations->sum(function ($variation) {
            return $variation->stockCount();
        });
    }

    /**
     * @return BelongsTo
     */
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return HasMany
     */
    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class)->orderBy('order', 'ASC');
    }
}
