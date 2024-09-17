<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticeArea extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'parent_id',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parent()
    {
        return $this->belongsTo(PracticeArea::class, 'parent_id');
    }
}
