<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    public function username()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');
    }

    public function cart()
    {
        return $this->hasOne('App\Models\Cart', 'customer_id', 'customer_id');
    }
    public function orderItems()
    {
        return $this->hasMany('App\Models\Admin\OrderItem', 'order_id', 'id');
    }

    // Relationship with OrderBilling
    public function orderBilling()
    {
        return $this->hasOne('App\Models\OrderBilling', 'order_id', 'id');
    }

  
}