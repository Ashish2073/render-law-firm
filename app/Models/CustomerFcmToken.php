<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerFcmToken extends Model
{
    use HasFactory;

    protected $table="customer_fcm_tokens";

    protected $fillable = [
        'customer_id',
        'fcm_token',
      
    ];
}
