<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Storage;
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
      return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
      return [];
    }

    public function rStore()
    {
        return $this->hasOne(Store::class,'user_id');
    }

    public function rProductLike()
    {
        return $this->hasMany(ProductUserLike::class,'user_id');
    }

    public function rDevice()
    {
        return $this->hasMany(DeviceUser::class,'user_id');
    }

    public function rStoreFollow()
    {
        return $this->hasMany(StoreUserFollow::class,'user_id');
    }

    public function rSearchLog()
    {
        return $this->hasMany(SearchLog::class,'user_id');
    }

    public function getcIconAttribute()
    {
        $icon =  $this->icon != null || $this->icon == ''?$this->icon:'default.png';
        if( file_exists( public_path(Storage::url('UserIcon')).'/'.$icon ) )
        {
            return asset(Storage::url('UserIcon').'/'.$icon);
        }
        else
        {
            return asset(Storage::url('UserIcon').'/default.png');
        }
    }
}
