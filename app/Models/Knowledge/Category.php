<?php

namespace App\Models\Knowledge;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Sluggable;

    public $table = 'knowledge_categories';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'slug',
        'created_at',
        'updated_at',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
