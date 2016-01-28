<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Google_Client;
use Illuminate\Support\Facades\Auth;
use App\GoogleAccount;
use Illuminate\Support\Facades\Redirect;

class GoogleAuthController extends Controller
{
    function getGoogleClient(){
        $client = new Google_Client();
        $client->setAccessType('offline');
        $client->setApplicationName(config('google.appName'));
        $client->setClientId(config('google.clientId'));
        $client->setClientSecret(config('google.clientSecret'));
        $client->setRedirectUri(config('google.redirectUri'));
        $client->setDeveloperKey(config('google.apiKey')); // API key
        $client->setScopes(config('google.scopes'));

        return $client;
    }
    function getGoogleClientS(){
        $client = $this->getGoogleClient(); //dd(Auth::user()->googleAccounts()->first());
        $acc = Auth::user()->googleAccounts()->first()->access_token;
        $acc = unserialize($acc);
        $client->setAccessToken($acc);
//        $client->refreshToken(config('google.refreshToken'));

        return $client;
    }

    function createAuthUrl(){
        $client = $this->getGoogleClient();
        $url = $authUrl = $client->createAuthUrl();
        return Redirect::to($url);
    }

    function oauth2callback(Request $request){
        $code = $request->input('code');
        $client = $this->getGoogleClient();
        $client->authenticate($code);
        $token = $client->getAccessToken();

        $user = Auth::user();
        $googleAccount = new GoogleAccount();
        $googleAccount->access_token = serialize($token);
        $user->googleAccounts()->save($googleAccount);

//        dd($client->getRefreshToken());
        return redirect('/buildGraph');
    }
}
