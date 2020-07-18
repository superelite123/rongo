<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreHasTag extends Model
{
    protected $table = 'store_has_tag';
    protected $fillable = ['tag_id'];
    public function rTag()
    {
        return $this->belongsTo(Tag::class,'tag_id');
    }
}
