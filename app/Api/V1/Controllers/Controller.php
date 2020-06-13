<?php

namespace App\Api\V1\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Tag;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function registerTag($label)
    {
        $tag = Tag::where('label',$label)->first();
        if($tag == null)
        {
            $tag = new Tag;
            $tag->label = $label;
            $tag->save();
        }
        return $tag->id;
    }
}
