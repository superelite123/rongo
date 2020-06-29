<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\ProductUserClick;
use App\User;
class ProductClickController extends Controller
{
    public function store(Request $request)
    {
        $response = ['success' => 1];
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
