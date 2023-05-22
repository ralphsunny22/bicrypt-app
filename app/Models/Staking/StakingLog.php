<?php

namespace App\Models\Staking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StakingLog extends Model
{
    use HasFactory;

    public function coin()
    {
        return $this->belongsTo(StakingCurrency::class);
    }
}