<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CustomerCase;
use App\Models\CustomerFcmToken;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use App\Models\Lawyer;

class Customer extends SanctumPersonalAccessToken
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = "customers";

    public function isPartOfCase($cases_id)
    {
        return $this->cases()->where('id', $cases_id)->exists();
    }

    public function cases()
    {
        return $this->belongsToMany(CustomerCase::class, 'customers'); 
    }


    public function fcm_token(){
        return $this->hasMany(CustomerFcmToken::class,'customer_id','id');
    }






    protected $fillable = [
        'name',
        'email',
        'phone',
        'otp',
        'social_media_id',
        'is_verified',
        'otp_created_at',
        'email_verified_at',
        'phone_verified_at',
        'password',
        'remember_token'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // protected function casts(): array
    // {
    //     return [
    //         'password' => 'hashed',
    //     ];
    // }

    protected $hidden = [
        'password',
        'remember_token',
        'fcm_token',
        'social_media_id',
        'phone',
        'otp',
        'otp_created_at',
        'otp_verified_at',
        'verification_token',
        'email_verified_at',
        'phone_verified_at',
        'created_at',
        'updated_at'

    ];
}
