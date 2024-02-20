<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;
use App\Traits\Uuid;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'username',
        'password',
        'member_type',
        'level',
        'is_active',
        'account_balance',
        'expiry_verification_date',
        'last_login_at',
        'last_login_ip'
    ];

    protected $dates = ['created_at', 'last_login_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::create($value)->format('d F Y H:i');
    }

    public function student()
    {
        return $this->hasOne('App\Models\MasterData\Student');
    }

    public function getLastLoginAtAttribute($value)
    {
        return $value == NULL ? '-' : Carbon::create($value)->diffForHumans();
    }

    public function userMemberCategory()
    {
        return $this->hasMany('App\Models\UserMemberCategory');
    }
}
