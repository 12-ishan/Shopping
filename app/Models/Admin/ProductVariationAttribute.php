<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductVariationAttribute extends Model
{
    protected $table = 'product_variation_attribute';

    protected $fillable = [
        'product_variation_id',
        'attributes_options_id',
        'status',
        'sort_order',
    ];

    public function variation()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }

    public function attributeOption()
    {
        return $this->belongsTo(AttributeOptions::class, 'attributes_options_id');
    }
}