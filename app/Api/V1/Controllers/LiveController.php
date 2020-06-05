<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
//Load Model
use App\User;
use App\Live;
class LiveController extends Controller
{
    //
    public function index()
    {
        return response()->json(['lives' => Live::all()]);
    }
}
