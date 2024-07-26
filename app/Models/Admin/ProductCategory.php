<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_category';

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}