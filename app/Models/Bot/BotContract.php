<?php

namespace App\Models\Bot;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotContract extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }
}