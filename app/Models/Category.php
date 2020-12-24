<?php

namespace App\Models;

use App\Models\Traits\HasChildren;
use App\Models\Traits\IsOrderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasChildren, IsOrderable;

    protected $guarded = [];

    public function scopeParents(Builder $builder)
    {
        $builder->whereNull('parent_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return HasMany|Category
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function products()
    {
        $this->hasMany(Product::class);
    }
}
