<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LawyerReview;
use App\Models\Proficience;
use App\Models\LawyerSocialMedia;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Customer;
use App\Models\CustomerCase;
use Spatie\Permission\Traits\HasRoles;

class Lawyer extends Authenticatable
{
    use HasFactory, HasRoles;
    protected $table = "lawyers";



    public function ratings()
    {
        return $this->hasMany(LawyerReview::class);
    }

    public function proficiencies()
    {

        return $this->belongsToMany(Proficience::class, 'lawyer_proficiencies', 'lawyer_id', 'proficience_id');
    }


    public function lawyerBookmarkByCustomer()
    {

        return $this->belongsToMany(Customer::class, 'bookmarks', 'lawyer_id', 'customer_id');

    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class, 'lawyer_id');
    }



    public function socialmedia()
    {
        return $this->hasMany(LawyerSocialMedia::class, 'lawyer_id', 'id');
    }




    public function updateAverageRating($newRating, $oldRating = null)
    {
        if ($oldRating) {

            $this->ratings_sum = $this->ratings_sum - $oldRating + $newRating;
        } else {
            $this->ratings_count = $this->ratings_count + 1;

            $this->ratings_sum += $newRating;

        }



        $this->avg_rating = $this->ratings_sum / $this->ratings_count;
        $this->save();


    }

    public function isPartOfCase($cases_id)
    {
        return $this->cases()->where('id', $cases_id)->exists();
    }

    public function cases()
    {
        return $this->belongsToMany(CustomerCase::class, 'lawyers');
    }


    public function getProfileImageAttribute($value)
    {

        return $value ? asset("lawyer/images/{$value}")
            : asset("customer_image/defaultcustomer.jpg");
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // protected $casts = [
    //     'avg_rating' => 'decimal:2',
    // ];

    protected $fillable = [
        'name',
        'email',
        'avg_rating',
        'ratings_sum',
        'ratings_count',
        'experience',
        'status',
        'description_bio',
        'otp',
        'social_media_id',
        'is_verified',
        'otp_created_at',
        'email_verified_at',
        'phone_verified_at',
        'password',
        'remember_token',
        'profile_image'
    ];

}
