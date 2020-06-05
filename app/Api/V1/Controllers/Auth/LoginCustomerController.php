<?php

namespace App\Api\V1\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Api\V1\Requests\LoginCustomerRequest;
use Illuminate\Http\Request;
use JWTAuth;
use Hash;
use Carbon\Carbon;
//Models
use App\User;

class LoginCustomerController extends AuthController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    /**
     * Confirm if user exist
     *
     * @param:uuid,nickname
     */
    public function login(Request $request)
    {
        $user = User::where('nickname',$request->nickname)->first();

        return $user != null?$user->id:-1;
    }
    /**
     * Confirm user's password
     * @param:nickname,uuid,password
     */
    public function Confirm(Request $request)
    {
        $user = User::find($request->id);
        if($user == null)
        {
            return 0;
        }

        if(Hash::check($request->password, $user->password)){
            $token = JWTAuth::fromUser($user,['exp' => Carbon::now()->addDays(7)->timestamp]);
            return $this->respondWithToken($token);
        }
        else{
            return -1;
        }
    }
}
