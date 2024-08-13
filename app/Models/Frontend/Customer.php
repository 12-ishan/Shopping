<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
     use HasApiTokens, Notifiable;

    protected $table = 'customers';

    protected $fillable = ['username', 'email', 'password'];

   
}