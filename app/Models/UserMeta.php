<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{

    protected $table = 'user_metas';
    protected $fillable = ['userId'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}