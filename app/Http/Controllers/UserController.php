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

            $user->save();
            return Redirect::back();
        }
    }
}
