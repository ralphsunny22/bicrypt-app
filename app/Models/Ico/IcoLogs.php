<?php

namespace App\Models\Ico;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IcoLogs extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ico()
    {
        return $this->belongsTo(ICO::class);
    }
}