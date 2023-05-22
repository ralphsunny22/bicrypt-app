<?php

namespace App\Models\Knowledge;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{

    public $table = 'knowledge_faq_categories';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'category',
        'created_at',
        'updated_at',
    ];

    public function faqQuestions()
    {
        return $this->hasMany(FaqQuestion::class, 'category_id', 'id');
    }
}
