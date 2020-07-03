<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Address;
use App\State;
use App\UserSetting;
use Storage;
use App\Traits\LoadList;
class UserSettingController extends Controller
{
    use LoadList;
    public function index()
    {
        $settings = auth()->user()->rSetting;
    }
    /**
     * Notification Settings
     *
     * notification_order
     * notification_sale
     * notification_product_live
     * notification_store_live
     */
    public function notifications()
    {
        $settings = auth()->user()->rSetting()
                    ->select(['key','value'])
                    ->where('key','like','notification_%')->get();
        return response()->json($settings);
    }
    public function setNotification(Request $request)
    {
        $key = 'notification_';
        switch($request->type)
        {
            //order
            case 1:
                $key .= 'order';
            break;
            //like product sale
            case 2:
                $key .= 'product_sale';
            break;
            //like product live
            case 3:
                $key .= 'product_live';
            break;
            //follow store live
            case 4:
                $key .= 'store_live';
            break;
        }
        $user = auth()->user();
        $setting = $user->rSetting()->where('key',$key)->first();
        if($setting == null)
        {
            $setting = new UserSetting;
            $setting->user_id = $user->id;
            $setting->key = $key;
        }
        $setting->value = $request->value;
        $setting->save();

        return response()->json(['key' => $setting->key,'value' => $setting->value]);
    }
}
