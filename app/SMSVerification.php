<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMSVerification extends Model
{
    //
    protected $table = 'sms_verifications';
    protected $fillable = ['phone_number','code'];
}
