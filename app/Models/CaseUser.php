<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseUser extends Model
{
    use HasFactory;

    protected $table="case_users";


    public function accuser_cases()
    {
        return $this->belongsToMany(CustomerCase::class, 'customers'); 
    }

}
