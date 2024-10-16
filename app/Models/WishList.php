<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    protected $fillable = ['user_id', 'product_id', 'variation_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(\App\Models\Admin\Product::class);
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
