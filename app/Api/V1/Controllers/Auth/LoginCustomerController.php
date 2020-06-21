<?php

namespace App\Api\V1\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Api\V1\Requests\LoginCustomerRequest;
use App\Api\V1\Requests\RegisterCustomerRequest;
use Illuminate\Http\Request;
use JWTAuth;
use Hash;
use Carbon\Carbon;
//Models
use App\User;
use App\DeviceUser;
use Config;
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
     * Reister Customer
     *
     * @param:nickname,uuid
     *
     * @response:
     *  Success
     *  1:success
     *  -1:Duplicated User
     *  -2:Deplicated Device
     */
    public function register(RegisterCustomerRequest $request){
        $response = ['success' => 1,'token' => null];
        $nickname   = $request->nickname;
        $uuid       = $request->uuid;
        //Check User Duplicate
        $dUser = User::where('nickname',$request->nickname)->first();
        if($dUser != null)
        {
            $response['success'] = -1;
            return response()->json($response);
        }
        $newUser = new User;
        $newUser->nickname = $request->nickname;
        $newUser->password = bcrypt(' ');
        $newUser->type = 2;
        $newUser->chat_id = uniqid();
        $newUser->fcm_token = $request->fcm_token;
        //check Device Duplicate
        $aDevice = DeviceUser::where('device',$request->uuid)->first();
        if($aDevice != null)
        {
            $response['success'] = -2;
        }else{
            $newUser->save();
            $response['chat_user_id'] = $newUser->chat_id;
            $newUser->rDevice()->saveMany([
                new DeviceUser(['device' => $request->uuid])
            ]);
        }

        $response['token'] = $this->responseToken(
                                JWTAuth::fromUser($newUser,['exp' => Carbon::now()->addDays(7)->timestamp])
                            );
        return response()->json($response);
    }
    /**
     *
     * @param:uuid,nickname
     * @response
     * Success:
     * -1:Invalid user
     * 0:No Device
     * 1:Success
     */
    public function login(RegisterCustomerRequest $request)
    {
        $response = ['success' => 1,'token' => null];
        $user = User::where('nickname',$request->nickname)->first();
        if($user == null){
            $response['success'] = -1;
        }else{
            if($user->rDevice()->where('device',$request->uuid)->first() == null)
            {
                $response['success'] = 0;
            }else{
                $response['chat_user_id'] = $user->chat_id;
                $response['token'] = $this->responseToken(
                                        JWTAuth::fromUser($user,['exp' => Carbon::now()->addDays(7)->timestamp])
                                     );
            }
        }
        return response()->json($response);
    }
    /**
     * New Device
     * @param:uuid,Change Code
     * Success
     * 1:Success
     * 0:Invalid Code
     * -1:Duplicate
     * -2:other user use this device
     * -3:you are alreay have this device
     */
    public function newDevice(Request $request)
    {
        $response = ['success' => -1,'access_token' => null];
        $user = User::where('password',bcrypt($request->code))->get();
        if($user->count() > 1){
            $response['success'] = -1;
        }
        else{
            if($user->count() == 0){
                $response['success'] = 0;
            }
            else{
                $user = $user[0];
                //check Device Duplicate
                $aDevice = $user->rDevice()->where('device',$request->uuid)->first();
                if($aDevice != null)
                {
                    if($aDevice->user_id != $user->id)
                        $response['success'] = -2;
                    else
                        $response['success'] = -3;
                }else{
                    $user->rDevice()->saveMany([
                        new DeviceUser(['device' => $request->uuid])
                    ]);
                    $user->fcm_token = $request->fcm_token;
                    $user->save();
                    $response['chat_user_id'] = $user->chat_user_id;
                }
                $response['token'] = $this->responseToken(
                    JWTAuth::fromUser($user[0],['exp' => Carbon::now()->addDays(7)->timestamp])
                );
            }
        }
        return response()->json($response);
    }
}
