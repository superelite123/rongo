<?php

namespace App\Api\V1\Controllers\Auth;

use Mail;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Api\V1\Requests\LoginSellerRequest;
use App\Mail\EmailVerificationCode;
use Illuminate\Http\Request;
use JWTAuth;
//Models
use App\User;
use Config;
use Carbon\Carbon;
use Hash;

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
        //$this->middleware('guest')->except('logout');
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
            if(!Hash::check($user->password,$request->password))
            {
                $this->Generate2faPin($user->id);
                return response()->json(['success' => $user->id]);
            }
            else
            {
                return response()->json(['success' => -2]);
            }
        }

        return response()->json(['success' => -1]);
    }
    /**
     * Log in Confirm
     *
     * @param
     * id:user_id
     * pwd:password
     */
    public function confirm(Request $request)
    {
        $user = User::find($request->id);
        //expired?
        // if($user->token_2fa_expiry < Carbon::now())
        // {
        //     return response()->json(['success' => 409]);
        // }
        // if($user->token_2fa != $request->pwd)
        // {
        //     $this->Generate2faPin();
        //     return response()->json(['success' => 401]);
        // }
        // thumbnail: null,
        // username: null,
        // email:null,
        // id:null,
        // token:null,

        $store = $user->rStore;
        $follows = 0;

        if ($store != NULL) {
            $follows = $store->rUsersFollow()->where('type', 1)->count();
            $evalutionLikes = $user->rStore->rEvaluationByType(1);
            $evalutionNoFeels = $user->rStore->rEvaluationByType(2);
            $evalutionDislikes = $user->rStore->rEvaluationByType(3);

            $evalution = [
                'like' => ($evalutionLikes == NULL) ? 0 : $evalutionLikes->count(),
                'notBad' => ($evalutionNoFeels == NULL) ? 0 : $evalutionNoFeels->count(),
                'dislike' => ($evalutionDislikes == NULL) ? 0 : $evalutionDislikes->count()
            ];
        } else {
            $evalution = [
                'like' => 0,
                'notBad' => 0,
                'dislike' => 0
            ];
        }
        // $follows = $user->rStore->rUsersFollow()->where('type', 1)->count();
        // $evalutionLikes = $user->rStore->rEvaluationByType(1);
        // $evalutionNoFeels = $user->rStore->rEvaluationByType(2);
        // $evalutionDislikes = $user->rStore->rEvaluationByType(3);



        $response['userInfo'] = [
            'id' => $user->id,
            'nickname' => $user->nickname,
            'email' => $user->email,
            'thumbnail' => $user->cIcon,
            'numFollowers' => ($follows == null) ? 0 : $follows,
            'evaluation' => $evalution
        ];

        $response['result'] = 0;
        $response['token'] = JWTAuth::fromUser($user,['exp' => Carbon::now()->addDays(7)->timestamp]);


        return response()->json($response);
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

        Mail::to($user->email)->send(new EmailVerificationCode($pin));
    }
}
