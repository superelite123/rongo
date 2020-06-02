<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Load Model
use App\User;
use App\Product;
class ProductController extends Controller
{
    //
    public function product($id)
    {
        return response()->json(Product::all());
    }
}
