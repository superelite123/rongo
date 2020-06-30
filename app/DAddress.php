<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DAddress extends Model
{
    //
    protected $table = 'd_addresses';

    protected $fillable = ['user_id','firstname_1','lastname_1','firstname_2','lastname_2',
                            'company','state_id','county','street','houst_number',
                            'phone_number','postal_code'
    ];
}
