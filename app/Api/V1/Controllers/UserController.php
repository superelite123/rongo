<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Address;
use App\State;
use Storage;
use App\Traits\LoadList;
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
    /**
     * Update User Info
     */
    public function show()
    {
        $user = auth()->user();

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
        $response['addresses']      = [];
        foreach($user->rHasAddress as $keyAddress)
        {
            $response['addresses'][] = $keyAddress->rAddress;
        }

        return response()->json($response);
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

        $response['user'] = $user;
        return response()->json($response);
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
    public function toArray(User $user)
    {
        $response = [];
        $response['id'] = $user->id;
        $response['name'] = $user->firstname_k;
        return $response;
    }
}
