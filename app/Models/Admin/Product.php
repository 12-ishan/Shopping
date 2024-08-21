<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function image()
    {
        return $this->belongsTo(Media::class, 'imageId');
    }

    public function productVariation()
    {
        return $this->hasMany(ProductVariation::class);
    }
   
    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function attributeOptions()
    {
        return $this->hasManyThrough(AttributeOptions::class, ProductAttribute::class, 'product_id', 'attribute_id', 'id', 'attribute_id');
    }
        
}
