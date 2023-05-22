<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class NotificationSetting extends Model
{
    protected $casts = [
        'mail_config' => 'object',
        'sms_config' => 'object',
        'global_shortcodes' => 'object'
    ];

    protected static function boot()
    {
        parent::boot();
        static::saved(function () {
            Cache::forget('NotificationSetting');
        });
    }
}