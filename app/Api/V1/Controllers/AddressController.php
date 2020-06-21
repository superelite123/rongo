<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\State;
use App\Traits\LoadList;
use Config;
class AddressController extends Controller
{

    public function index()
    {
        $response = [];
        return response()->json($this->loadStores([]));
    }

    public function show($id)
    {
        $response = [];
        $address = Address::find($id);

        return response()->json($address);
    }

    public function store(Request $request)
    {

    }
}
