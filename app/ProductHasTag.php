<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductHasTag extends Model
{
    //
    protected $table = 'product_has_tag';
    protected $fillable = ['tag_id'];
    public function rTag()
    {
        return $this->belongsTo(Tag::class,'tag_id');
    }
}
