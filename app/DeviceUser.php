<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceUser extends Model
{
    protected $table = 'device_user';
    protected $fillable = [
        'device'
    ];

}
