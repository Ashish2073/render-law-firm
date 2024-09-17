<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Lawyer;

class Message extends Model
{
    use HasFactory;

    public function customerSender(){
        return $this->belongsTo(Customer::class,'sender_id');
    }

    
    public function customerReceiver(){
        return $this->belongsTo(Customer::class,'receiver_id');
    }


    public function lawyerSender(){
        return $this->belongsTo(Lawyer::class,'sender_id');
    }

    
    public function lawyerReceiver(){
        return $this->belongsTo(Lawyer::class,'receiver_id');
    }
}
