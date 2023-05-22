<?php

namespace App\Models\Forex;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForexLogs extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function investment()
    {
        return $this->belongsTo(ForexInvestments::class, 'investment_id');
    }
}