<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $table = 'product_attribute';

    // public function attribute()
    // {
    //     return $this->belongsTo(Product::class);
    // }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attributeOptions()
    {
        return $this->hasMany(AttributeOptions::class, 'attribute_id', 'attribute_id');
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}