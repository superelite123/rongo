<?php

namespace App\Api\V1\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Api\V1\Requests\LoginSellerRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
//Models
use App\User;
use Config;
use Carbon\Carbon;
class LoginSellerController extends AuthController
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
     * Log Seller in
     *
     * @param:email,password
     */
    public function login(LoginSellerRequest $request,JWTAuth $JWTAuth)
    {
        $user = User::where(['email' => $request->email])->first();

        if($user != null)
        {
            $this->Generate2faPin($user->id);
            return response()->json(['success' => $user->id]);
        }
        {
            return response()->json(['success' => -1]);
        }
    }
    /**
     * Log in Confirm
     *
     * @param:user_id,password
     */
    public function confirm(Request $request)
    {
        $user = User::find($request->id);
        //expired?
        if($user->token_2fa_expiry < Carbon::now())
        {
            return response()->json(['success' => 0]);
        }
        if($user->token_2fa != $request->pwd)
        {
            $this->Generate2faPin();
            return response()->json(['success' => -1]);
        }
        if($user->token_2fa != $request->pwd)
        {
            $token = JWTAuth::fromUser($user,['exp' => Carbon::now()->addDays(7)->timestamp]);
            return response()->json(['success' => -1,'token' => $token]);
        }
    }

    /**
     * @Generate Two factor pin code
     */
    public function Generate2faPin($userId)
    {
        $pin = mt_rand(100000, 999999);
        $user = User::find($userId);
        $user->token_2fa = $pin;
        $user->token_2fa_expiry = Carbon::now()->addMinutes(Config::get('constants.2fa_expiry'));
        $user->save();
    }
}
