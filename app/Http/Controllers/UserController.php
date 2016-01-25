<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function getConnectedAccounts(){
        return json_encode(Auth::user()->googleAccounts()->get());
    }

    function show($uid){
        $data = (new RdfController())->getMyData();
        return json_encode($data);
    }
}
