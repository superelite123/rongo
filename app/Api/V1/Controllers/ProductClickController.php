<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\ProductUserClick;
use App\User;
use App\Helper\CommonFunction;
class ProductClickController extends Controller
{
    use CommonFunction;
    public function store(Request $request)
    {
        $response = ['success' => 1];
        return response()->json($this->runProductRanking());
        $user = auth()->user();
        $product_id = $request->product_id;
        $record = $user->rProductClick()->where('product_id' , $product_id)->first();
        if($record == null)
        {
            $user->rProductClick()->saveMany([
                new ProductUserClick(['product_id' => $product_id])
            ]);
        }
        else
        {
            $response['success'] = 0;
        }

        return response()->json($response);
    }
}
