<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class WebsiteLogo extends Model
{
    protected $table = 'website_logo';

    public function image()
    {
        return $this->belongsTo('App\Models\Admin\Media', 'imageId', 'id');
    }

}