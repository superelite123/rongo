<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JWTAuth;
use App\User;
use App\UserSetting;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function confirmEmailChange(Request $request)
    {
        $loginUrl = 'http://localhost:3000';

        $setting = UserSetting::where('value',$request->token)->first();
        if($setting == null)
        {
            return view('email_change_confirm_error',['loginUrl' => $loginUrl]);
        }
        else
        {
            $user = User::find($setting->user_id);
            $setting = $user->rSetting()->where('key','change_email')->first();
            if($setting == null)
            {
                return view('email_change_confirm_error',['loginUrl' => $loginUrl]);
            }
            $user->email = $setting->value;
            $user->save();
            return view('email_change_confirm',['loginUrl' => $loginUrl]);
        }
    }
}
