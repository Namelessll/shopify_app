<?php

namespace App\Http\Controllers\InstagramControllers;

use App\Http\Controllers\Controller;
use App\Models\InstagramModel;
use Illuminate\Support\Facades\Cache;
use App\Classes\Instagram\libs\Requests;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InstagramController extends Controller
{
    private static $clientId;
    private static $clientSecretKey;
    private static $authRedirect;

    public function __construct()
    {
        self::$clientId = config('app.instagram_client_id');
        self::$clientSecretKey = config('app.instagram_secret_key');
        self::$authRedirect = config('app.instagram_auth_redirect');
    }

    public function authorizeInstagram(Request $request) {
        $data = [
            'client_id'     => self::$clientId,
            'client_secret' => self::$clientSecretKey,
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => self::$authRedirect,
            'code'          => $request->get('code')
        ];

        $user_id = Cache::get('user_id');
        $result = Requests::sendPostCurlRequest('/oauth/access_token', $data);

        InstagramModel::saveUserToken($user_id, $result);

        $params = [
            'grant_type' => 'ig_exchange_token',
            'client_secret' => self::$clientSecretKey,
            'access_token' => InstagramModel::getAccessToken($user_id)->access_token
        ];

        InstagramModel::setLongLivedAccessToken($user_id, Requests::sendGetCurlRequest('/access_token', $params));


        Auth::login(User::find($user_id));

        return redirect()->route('home');
    }
}
