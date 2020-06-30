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
        'nickname', 'email', 'password','address_id','firstname_h','lastname_h','firstname_k',
        'lastname_k','phone_number','photo'
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

    public function rHasAddress()
    {
        return $this->hasMany(UserHasAddress::class,'user_id');
    }
    public function rAddress()
    {
        return $this->belongsTo(Address::class,'address_id');
    }
    public function rProductClick()
    {
        return $this->hasMany(ProductUserClick::class,'user_id');
    }
    public function rCard()
    {
        return $this->hasMany(UserCard::class,'user_id');
    }
    public function rDAddress()
    {
        return $this->hasMany(DAddress::class,'user_id');
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

    /**
     * Specifies the user's FCM token
     *
     * @return string
     */
    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }
}
