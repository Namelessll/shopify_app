<?php


namespace App\Classes\Instagram;

use GuzzleHttp\Client;
use App\Models\InstagramModel;
use GuzzleHttp\Exception\GuzzleException;

class Handler
{
    protected static $_instance;
    protected static $userId;
    private static $access_token;
    private $client;
    private $clientProfile;

    private static function setAccessToken($token) {
        self::$access_token = $token->access_token;
    }

    private function __construct() {
        $this->client = new Client([
            'base_uri' => 'https://graph.instagram.com',
        ]);

        $this->clientProfile = new Client([
            'base_uri' => 'https://www.instagram.com',
        ]);
    }

    public static function getInstance($userId) {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        if ($userId) {
            self::$userId = $userId;
            self::setAccessToken(InstagramModel::getAccessToken(self::$userId));
        }

        return self::$_instance;
    }

    private function __clone() {
    }

    private function __wakeup() {
    }

    public function getInstagramProfile() {
        if (self::$access_token){
            try {
                $response = $this->client->request('GET', '/me', [
                    'query' => [
                        'fields' => 'id,username',
                        'access_token' => self::$access_token
                    ]
                ]);
            } catch (GuzzleException $e) {
                return [];
            }

            return json_decode($response->getBody()->getContents());
        }

        return [];
    }

    public function getProfilePostIds() {
        if (self::$access_token){

            try {
                $response = $this->client->request('GET', '/me/media', [
                    'query' => [
                        'fields' => 'id,caption',
                        'access_token' => self::$access_token
                    ]
                ]);
            } catch (GuzzleException $e) {
                return [];
            }
             return json_decode($response->getBody()->getContents())->data;
        }
        return [];
    }

    public function getProfilePostsByIds($limit, $data) {
        if (self::$access_token){
            $posts = [];
            foreach(array_slice($data, 0, $limit) as $postId) {

                try {
                    $data = $this->client->request('GET', '/' . $postId->id, [
                        'query' => [
                            'fields' => 'id,media_type,media_url,username,timestamp',
                            'access_token' => self::$access_token
                        ]
                    ]);
                } catch (GuzzleException $e) {
                    return [];
                }


                $response = json_decode($data->getBody()->getContents());
                $posts[] = [
                    "id" => $postId->id ?? "",
                    "caption" => $postId->caption ?? "",
                    "media_url" => $response->media_url,
                    "username" => $response->username
                ];

            }
            return $posts;
        }
        return [];
    }

}
