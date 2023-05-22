<?php

namespace App\Models\Knowledge;

use Illuminate\Database\Eloquent\Model;

class FaqQuestion extends Model
{

    public $table = 'knowledge_faq_questions';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'answer',
        'question',
        'created_at',
        'updated_at',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'category_id');
    }
}
