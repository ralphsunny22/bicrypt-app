<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotTiming extends Model
{
    use HasFactory;
    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }
}