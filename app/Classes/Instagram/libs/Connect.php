<?php


namespace App\Classes\Instagram\libs;

class Connect
{
    private $clientId;
    private $clientSecretKey;
    private $authRedirect;

    public function __construct()
    {
        $this->clientId = config('app.instagram_client_id');
        $this->clientSecretKey = config('app.instagram_secret_key');
        $this->authRedirect = config('app.instagram_auth_redirect');
    }

    protected function generateConnectRoute() {
        return "https://api.instagram.com/oauth/authorize?client_id={$this->clientId}&redirect_uri={$this->authRedirect}&scope=user_profile,user_media&response_type=code";
    }

    public function returnConnectRoute() {
        return $this->generateConnectRoute();
    }
}
