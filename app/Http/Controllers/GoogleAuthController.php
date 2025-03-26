<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Illuminate\Support\Facades\Session;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CALENDAR_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CALENDAR_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_CALENDAR_REDIRECT_URI'));
        $client->addScope(\Google_Service_Calendar::CALENDAR);

        $authUrl = $client->createAuthUrl();
        return redirect()->away($authUrl);
    }

    public function handleGoogleCallback()
    {
//        dd(request()->all());
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CALENDAR_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CALENDAR_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_CALENDAR_REDIRECT_URI'));
        $client->addScope(\Google_Service_Calendar::CALENDAR);
        $client->setAccessType('offline'); // refresh_token を得る
        $client->setPrompt('consent');

        if (request()->has('code')) {
            $token = $client->fetchAccessTokenWithAuthCode(request()->get('code'));

            if (isset($token['access_token'])) {
                // セッション or DBに保存する
                Session::put('google_token', $token);
                return redirect('/')->with('success', 'Google連携が完了しました！');
            } else {
                return redirect('/')->with('error', 'Googleトークンの取得に失敗しました');
            }
        }

        return redirect('/')->with('error', 'Google認証に失敗しました');
    }
}
