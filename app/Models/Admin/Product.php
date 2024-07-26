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
}