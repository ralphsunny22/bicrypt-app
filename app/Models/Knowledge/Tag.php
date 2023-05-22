<?php

namespace App\Models\Knowledge;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Sluggable;

    public $table = 'knowledge_tags';

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
        return $this->belongsToMany(Article::class);
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
