<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lawyer;

class Proficience extends Model
{
    use HasFactory;

    protected $table="proficiencies";

    public function lawyers()
    {
        return $this->belongsToMany(Lawyer::class, 'lawyer_proficiences','proficience_id','lawyer_id');
    }


    public function parent()
    {
        return $this->belongsTo(Proficience::class, 'parent_id');
    }

  
    public function children()
    {
        return $this->hasMany(Proficience::class, 'parent_id');
    }




}
