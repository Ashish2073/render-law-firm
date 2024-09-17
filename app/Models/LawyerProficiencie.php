<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lawyer;
use App\Models\Proficience;

class LawyerProficiencie extends Model
{
    use HasFactory;
    protected $table="lawyer_proficiencies";

    public function proficienceBelongToLawyer(){
        return $this->belongsTo(Lawyer::class,"lawyer_id","id");
    }

    public function lawyersBelongToProficience(){
        return $this->belongsTo(Proficience::class,"proficiencie_id ","id");
    }



}
