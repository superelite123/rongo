<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\State;
use App\Traits\LoadList;
use App\DAddress;
use Config;
class DAddressController extends Controller
{

    public function index()
    {
        return response()->json(auth()->user()->rDAddress);
    }

    public function show($id)
    {
        $response = [];
        $address = DAddress::find($id);

        return response()->json($address);
    }

    public function store(Request $request)
    {
        return response()->json(auth()->user()->rDAddress()->save(new DAddress($request->all())));

    }
}
