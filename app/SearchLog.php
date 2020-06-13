<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchLog extends Model
{
    //
    protected $table = 'search_log';
    protected $fillable = ['user_id','keyword'];
}
