<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $table = 'product_variation';

    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'stock',
        'status',
        'sort_order',
        
    ];

    public function attributes()
    {
        return $this->hasMany(ProductVariationAttribute::class, 'product_variation_id');
    }

    public function variationAttribute()
    {
        return $this->hasMany(ProductVariationAttribute::class, 'product_variation_id');
    }
}