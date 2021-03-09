<?php


namespace App\Classes\Instagram\libs;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class CacheHandler
{
    private $user = array();
    private $id;

    public function __construct($userId) {
        $this->id = $userId;
        if (Cache::has("$userId")) {
            $this->user[$userId] = Cache::get("$userId");
        } else {
            Cache::add("$userId", 1000, Carbon::now()->addDays(30));
            $this->user[$userId] = 1000;
        }
    }

    public function __get($name) {
        if ($this->$name[$this->id] > 0) {
            return $this->$name[$this->id];
        } else
            return false;
    }

    public static function view($userId) {
        Cache::decrement($userId, 1);
    }
}
