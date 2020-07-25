<?php

namespace App\Api\V1\Controllers;

use Mail;
use Illuminate\Http\Request;
use App\User;
use App\UserSetting;
use App\Address;
use App\State;
use Storage;
use App\Traits\LoadList;
use Hash;
use App\Mail\ChangeDeviceCode;

class UserController extends Controller
{
    use LoadList;
    public function me()
    {

    }
    /**
     * 6.15 matuoka
     * Update User Detail
     *
     * @param:
     * @response
     * success = 1,-1
     */
    public function update(Request $request)
    {
        $id = $request->id == 0?auth()->user()->id:$request->id;
        $user = User::find($id);

        $address = $user->rAddress != null ? $user->rAddress : new Address;
        $addreess->state_id = $request->state_id;
        $addreess->county = $request->county;
        $addreess->street = $request->street;
        $addreess->house_number = $request->house_number;
        $addreess->postal_code = $request->postal_code;
        $address->save();

        //save user info
        $user->address_id = $address->id;
        $user->firstname_h = $request->firstname_h;
        $user->lastname_h = $request->lastname_h;
        $user->firstname_k = $request->firstname_k;
        $user->lastname_k = $request->lastname_k;
        $user->nickname = $request->nickname;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->ale = $request->ale;
        $user->phone_number = $request->phone_number;
        $user->save();

        if($request->hasFile('icon'))
        {
            $req = new Request;
            $req->image = $request->icon;
            $this->uploadPhoto($req);
        }

        return response()->json(auth()->user());
    }
    /**
     * 6.17
     * Upload Profile Photo
     */
    public function uploadPhoto(Request $request)
    {
        if(!$request->hasFile('image')) {
            return response()->json(['upload_file_not_found'], 400);
        }
        $file = $request->file('image');
        if(!$file->isValid()) {
            return response()->json(['invalid_file_upload'], 400);
        }

        $user = auth()->user();
        $file = Storage::disk('user_icon')->putFileAs('',$file,$user->id.'.png');
        $path = asset(Storage::url('UserIcon')).'/'.$file;
        $user->icon = $file;
        $user->save();
        return response()->json(['path' => $path]);
    }

    /*
    * Delete User
    *
    */
    public function deleteUser(Request $request)
    {
        $user = auth()->user();
        $success = $user->delete();
        $user->rDevice()->delete();
        $user->rStoreFollow()->delete();
        $user->rSetting()->delete();
        return response()->json(['success' => $success]);
    }

    /**
     * Update User Info
     */
    public function show()
    {
        return response()->json($this->toArray(auth()->user()));
    }
    public function addAle(Request $request)
    {
        $user = auth()->user();
        $user->ale += $request->ale;
        $user->save();
        return response()->json(['ale' => $user->ale]);
    }
    public function store(Request $request)
    {
        $response = ['success' => 1];

        $data = $request->except(['icon','address']);

        //save user info
        $user = auth()->user();
        $user->update($data);
        //save address
        if($user->rAddress != null)
        {
            $address = $user->rAddress;
            $address->update($request->address);
            $address->save();
        }
        else
        {
            $address = new Address($request->address);
            $address->save();
        }
        $user->address_id = $address->id;
        $user->save();
        //save icon
        $req = new Request;
        $req->image = $request->icon;
        $this->uploadPhoto($req);

        return response()->json($this->toArray( $user ));
    }
    public function updateEmail(Request $request)
    {
        $response = ['success' => 1];
        $user = auth()->user();
        $user->email = $request->email;
        $user->save();
        $response['email'] = $user->email;
        return response()->json($response);
    }

    public function registerAccountInfo(Request $request) {
        $user = auth()->user();

        $response = [];
        $user->email            = $request->email;
        $user->firstname_h      = $request->firstname_h;
        $user->lastname_h       = $request->lastname_h;
        $user->firstname_k      = $request->firstname_k;
        $user->lastname_k       = $request->lastname_k;
        $user->phone_number     = $request->phone_number;

        $user->save();

        $response['success'] = 1;
        $response['user'] = $this->toArray( $user );

        return response()->json($response);
    }

    public function getInviteCode()
    {
        $user = auth()->user();
        $user->rSetting()->where('key','invite_code')->delete();
        $setting = new UserSetting;
        $setting->user_id = $user->id;
        $setting->key = 'invite_code';
        $setting->value = mt_rand(100000, 999999);
        $setting->save();
        return response()->json(['inviteCode' => $setting->value]);
    }
    public function toArray(User $user)
    {
        $response = [];

        $response['icon']           = Storage::disk('user_icon')->exists($user->icon)?asset(Storage::url('UserIcon/'.$user->icon)):null;
        $response['firstname_h']    = $user->firstname_h;
        $response['lastname_h']     = $user->lastname_h;
        $response['firstname_k']    = $user->firstname_k;
        $response['lastname_k']     = $user->lastname_k;
        $response['nickname']       = $user->nickname;
        $response['gender']         = $user->gender;
        $response['email']          = $user->email;
        $response['phone_number']   = $user->phone_number;
        $response['address']        = $user->rAddress;
        $response['ale']            = $user->ale;
        $response['inviteCode']     = $user->invite_code;
        return $response;
    }

    public function changePassword(Request $request)
    {
        $password = $request->password;
        $user = auth()->user();
        $response = ['success' => 1];
        if(Hash::check($password, $user->password))
        {
            $response['success'] = -1;
        }
        else
        {
            $response['success'] = -2;
        }
        $user->password = Hash::make($password);
        $user->save();
        return response()->json($response);
    }
    /**
     * @Generate Two factor pin code
     */
    public function changeUserDeivce(Request $request) {
        $user = auth()->user();

        $pin = mt_rand(100000, 999999);

        $user->password = bcrypt($pin);
        // $user->token_2fa_expiry = Carbon::now()->addMinutes(Config::get('constants.2fa_expiry'));
        $user->save();

        Mail::to($user->email)->send(new ChangeDeviceCode($pin));

        return response()->json([ 'success' => true ]);
    }
}
