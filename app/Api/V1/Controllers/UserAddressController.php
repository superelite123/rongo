<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\UserHasAddress;

class UserAddressController extends Controller
{
    /**
     * Followed Users
     */
    public function index($type)
    {
        $response = [];

        $response['addresses']      = [];
        foreach($user->rHasAddress as $keyAddress)
        {
            $response['addresses'][] = $keyAddress->rAddress;
        }

        return response()->json($response);
    }
}
