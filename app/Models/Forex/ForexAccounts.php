<?php

namespace App\Models\Forex;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForexAccounts extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}