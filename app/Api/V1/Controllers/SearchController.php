<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\Traits\LoadList;
use App\SearchLog;
use Config;
class SearchController extends Controller
{
    use LoadList;
    /**
     * 6.13
     */
    public function index(Request $request)
    {
        $response = [];
        $options = [];
        $options['keyword'] = $request->keyword;

        switch($request->type)
        {
            case 0:
                $response['stores']     = $this->loadStores($options);
                $response['products']   = $this->loadProducts($options);
                $response['lives']      = $this->loadLives($options);
            break;
            case 1:
                $response['stores'] = $this->loadStores($options);
            break;
            case 2:
                $response['products'] = $this->loadStores($options);
            break;
            case 3:
                $response['lives'] = $this->loadStores($options);
            break;
        }
        if(auth()->user()->rSearchLog()->where('keyword',$options['keyword'])->first() == null)
        {
            auth()->user()->rSearchLog()->save(new SearchLog(['keyword' => $options['keyword']]));
        }

        return response()->json($response);
    }

    public function logs()
    {
        return response()->json(auth()->user()->rSearchLog()->select('keyword')->get());
    }
}
