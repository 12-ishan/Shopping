<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    public function product()
    {
        return $this->belongsTO('App\Models\Admin\Product', 'product_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Admin\Order', 'id', 'order_id');
    }


}