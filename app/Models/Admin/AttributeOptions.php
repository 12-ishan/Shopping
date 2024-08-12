<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AttributeOptions extends Model
{
    protected $table = 'attributes_options';

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}