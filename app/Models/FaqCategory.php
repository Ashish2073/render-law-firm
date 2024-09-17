<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Faq;

class FaqCategory extends Model
{
    use HasFactory;

    protected $table = "faq_categories";

    public function faq()
    {

        return $this->belongsToMany(Faq::class, 'faq_with_categories', 'category_id', 'faq_id');
    }
}