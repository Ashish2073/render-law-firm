<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobStatus extends Model
{
    use HasFactory;

    protected $table="job_status";


    protected $fillable = [
        'job_id',
        'job_name',
        'status',
        'push_notification_id',
        'error_message',
        
    ];



}
