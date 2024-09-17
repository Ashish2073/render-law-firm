<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyerReview extends Model
{
    use HasFactory;

    protected $table = "lawyer_ratings";

    protected $fillable = [
        'lawyer_id',
        'customer_id',
        'review',
        'rating',
        
    ];
}
