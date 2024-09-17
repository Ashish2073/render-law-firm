<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WelcomeMessage extends Model
{
    use HasFactory;

    protected $table='welcome_messages';

    protected $fillable = [
        'title',
        'content',
        'image',
    ];
}
