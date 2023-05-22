<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'name',
        'firstname',
        'lastname',
        'username',
        'country',
        'profile_photo_path',
        'zip',
        'state',
        'city',
        'ref_by',
        'role_id',
        'ethAddress',
        'phone'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'address' => 'object',
        'ver_code_send_at' => 'datetime'
    ];

    protected $data = [
        'data' => 1
    ];

    public function login_logs()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('id', 'desc');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class)->where('status', '!=', 0);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class)->where('status', '!=', 0);
    }

    public function wallets($type)
    {
        return $this->hasMany(Wallet::class)->where('type', $type)->get();
    }

    public function frozen_wallets()
    {
        return WalletsFrozen::where('user_id', $this->id)->first();
    }

    public function practice_log()
    {
        return $this->hasMany(\App\Models\PracticeLog::class)->orderby('created_at', 'desc');
    }

    public function scheduled_orders()
    {
        return $this->hasMany(\App\Models\ScheduledOrders::class)->orderby('created_at', 'desc');
    }

    public function thirdparty_transactions()
    {
        return $this->hasMany(\App\Models\ThirdpartyTransactions::class)->orderby('created_at', 'desc');
    }

    public function trade_log()
    {
        return $this->hasMany(\App\Models\TradeLog::class)->orderby('created_at', 'desc');
    }

    public function wallet()
    {
        return $this->hasMany(\App\Models\Wallet::class)->orderby('created_at', 'desc');
    }

    public function wallets_transactions()
    {
        return $this->hasMany(\App\Models\WalletsTransactions::class)->orderby('created_at', 'desc');
    }

    // SCOPES

    public function getFullnameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
    public function scopeActive()
    {
        return $this->where('status', 1);
    }

    public function scopeBanned()
    {
        return $this->where('status', 0);
    }

    public function scopeEmailUnverified()
    {
        return $this->whereNull('email_verified_at');
    }

    public function scopeSmsUnverified()
    {
        return $this->where('sv', 0);
    }
    public function scopeEmailVerified()
    {
        return $this->whereNotNull('email_verified_at');
    }

    public function scopeSmsVerified()
    {
        return $this->where('sv', 1);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


    public function sendEmailVerificationNotification()
    {
        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $this->getKey(),
                'hash' => sha1($this->getEmailForVerification()),
            ]
        );
        notify($this, 'EMAIL_VERIFY', [
            "url" => $url,
        ], ['email']);
    }

    public function sendPasswordResetNotification($token)
    {
        $url = url(route('password.reset', [
            'token' => $token,
            'email' => $this->getEmailForPasswordReset(),
        ], false));
        notify($this, 'PASS_RESET_CODE', [
            "url" => $url,
        ], ['email']);
    }

    public function routeNotificationForOneSignal()
    {
        return ['include_external_user_ids' => [strval($this->id)]];
    }
}