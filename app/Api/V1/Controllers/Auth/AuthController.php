<?php

namespace App\Api\V1\Controllers\Auth;

use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\JWTAuth;
use App\Api\V1\Controllers\Controller;
use Auth;
class AuthController extends Controller
{
    //
    protected function respondWithToken($token)
    {
      return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60
      ]);
    }

    public function logout(Request $request)
    {
        $user = auth()->guard('api')->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json([ 'data' => 'User logged out.' ], 200);
    }
}
