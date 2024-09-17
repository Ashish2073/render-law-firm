<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table="faqs";

    public static function getFaqWithCategories()
    {
        return self::query()->join('faq_with_categories', 'faqs.id', '=', 'faq_with_categories.faq_id')
            ->join('faq_categories', 'faq_with_categories.category_id', '=', 'faq_categories.id')
            ->select(
                'faq_categories.name as category',
                'faq_categories.id as category_id',
                'faqs.question as question',
                'faqs.answer as answer',
                'faqs.status as status',
                'faqs.id as id'
            );
         
    }
}
