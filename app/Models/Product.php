<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'body',
        'sku',
        'price_cents',
        'currency',
        'inventory_qty',
        'is_published',
    ];

    protected $casts = [
        'price_cents' => 'integer',
        'inventory_qty' => 'integer',
        'is_published' => 'boolean',
    ];

    public function media(): HasMany
    {
        return $this->hasMany(ProductMedia::class)->orderBy('sort_order')->orderBy('id');
    }
}

