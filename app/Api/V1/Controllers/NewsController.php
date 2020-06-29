<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\News;
use App\Traits\LoadList;
class NewsController extends Controller
{
    use LoadList;
    public function index()
    {
        $newses = News::whereIn('receiver',[0,auth()->user()->id])->get();
        $response = [];
        foreach($newses as $news)
        {
            $response[] = $this->newstoArray($news);
        }

        return response()->json($response);
    }
}
