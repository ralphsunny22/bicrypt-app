<?php

namespace App\Models\P2P;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P2PAds extends Model
{
    use HasFactory;
    protected $table = "p2p_ads";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(P2PCurrency::class);
    }
}