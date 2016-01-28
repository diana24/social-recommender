<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function getConnectedAccounts(){
        return json_encode(Auth::user()->googleAccounts()->get());
    }

    function show($uid){
        $data = (new RdfController())->getMyData();
        return json_encode($data);
    }

    public function update(Request $request){
        if (Auth::check())
        {
            $id = Auth::user()->id;
            $user = User::find($id);

            $validator = Validator::make(
                array(
                    'name' => $request->input('name'),
                    'email' => $request->input('email')
                ),
                array(
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,'.$id
                )
            );
            if ($validator->fails())
            {
                return Redirect::back()->withErrors($validator->errors());
            }

            $user->name = $request->input('name');
            $user->email = $request->input('email');

            $oldPassword = $request->input('old_password');
            $newPassword = $request->input('new_password');
            $rPassword = $request->input('password_confirmation');

            if(isset($newPassword) && isset($oldPassword) && isset($rPassword)){
                if (Hash::check($request->input('oldPassword'), $user->password)){
                    if ($newPassword==$rPassword){
                        $user->password = Hash::make($newPassword);
                        $user->save();
                        $error = "Password changed succesfully!";
                    }
                    else{
                        $error = "Passwords don't match!";
                    }
                }
                else{
                    $error = "Old password is incorrect!";
                }
                if(isset($error)){
                    return Redirect::back()->withErrors($error);
                }
            }

            $user->save();
            return Redirect::back();
        }
    }
}
