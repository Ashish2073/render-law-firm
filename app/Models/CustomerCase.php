<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CaseFile;

class CustomerCase extends Model
{
    use HasFactory;

    protected $table = "cases";


    // public function sendAssignedLawyerToCustomerCases($customer){

    // }


    public function caseFiles()
    {
        return $this->hasMany(CaseFile::class, 'case_id', 'id');
    }


    public function getFileNameAttribute($value)
    {
        return $value ? asset('cases_file/' . $value) : 'N/A';
    }





}
