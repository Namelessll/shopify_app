<?php


namespace App\Classes\Instagram\libs;


use App\Models\UserModel;
use App\Models\ShopifyModel;
use App\Models\InstagramModel;
use App\Classes\Instagram\Handler;
use App\Classes\Instagram\libs\CacheHandler;
use Carbon\Carbon;

class Helper
{
    private $userPlan;
    private $userId;
    private $cache;

    public function __construct($id) {
        $this->userId = $id;
        $this->userPlan = $this->getUserPlan($id);
        $this->cache = new CacheHandler($id);
    }

    private function getUserPlan($userId) {
        return UserModel::getUserField($userId, 'plan_id')->plan_id;
    }

    private function isReadyToUpdate($userId) {
        $lastPostsUpdate = InstagramModel::getCroneUpdateTime($userId)->created_at ?? null;
//        dd($lastPostsUpdate, Carbon::now(), Carbon::now()->gt(Carbon::parse($lastPostsUpdate)));
        if (empty($lastPostsUpdate) || Carbon::now()->gt(Carbon::parse($lastPostsUpdate))) {
            return true;
        } else {
            return false;
        }
    }

    private function isFreePlan($planId) {
        if (UserModel::getFreePlan()->id === $planId)
            return true;
        else
            return false;
    }

    private function isAvailableToView($userId, $planId) {
        $views = $this->cache->user;

        if (!$views) {
            return false;
        }

        return true;
    }

    private function setPostTimer($userId, $planId) {
        $planTerms = unserialize(ShopifyModel::getPlanById($planId)->terms_plan);
        return InstagramModel::createCrone($userId, $planTerms['Post_update_time']);
    }

    public function healthCheckConnection() {
        try {
            Handler::getInstance($this->userId)->getInstagramProfile();
            return true;
        } catch (\Throwable $exception) {
            return false;
        }
    }

    public function getAvailableViews() {
//        dd($this->cache, $this->cache->user);
        return $this->cache->user;
    }

    public function getPosts() {
        try {
            if ($this->isFreePlan($this->userPlan)) {
                if ($this->isReadyToUpdate($this->userId)) {
                    if ($this->isAvailableToView($this->userId, $this->userPlan)) {
                        $posts = Handler::getInstance($this->userId)->getProfilePostsByIds(8, Handler::getInstance($this->userId)->getProfilePostIds());
                        InstagramModel::savePosts($this->userId, $posts);
                        $this->setPostTimer($this->userId, $this->userPlan);
                    }
                    CacheHandler::view($this->userId);
                }
            } else {
                if ($this->isReadyToUpdate($this->userId)) {
                    $posts = Handler::getInstance($this->userId)->getProfilePostsByIds(8, Handler::getInstance($this->userId)->getProfilePostIds());
                    InstagramModel::savePosts($this->userId, $posts);
                    $this->setPostTimer($this->userId, $this->userPlan);
                }
            }

            $posts = InstagramModel::getPostsWithDots($this->userId);
            $posts->each(function (&$item, $key) {
                $item->count_dots = $item->dots->count();
            });

            return $posts->unique('id');
        } catch (\Throwable $exception) {
            return [];
        }

    }

}
