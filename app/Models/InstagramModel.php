<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InstagramModel extends Model
{
    use HasFactory;

    public static function saveUserToken($userId, $request) {
        return DB::table('table_instagram_access')
            ->updateOrInsert(
                [
                    //'profile_id' => $userId,
                    'user_id' => $request->user_id
                ],
                [
                    'profile_id' => $userId,
                    'access_token' => $request->access_token,
                    'user_id' => $request->user_id,
                    'created_at' => Carbon::now(),
                ]
            );
    }

    /* Get instagram token */
    public static function getAccessToken($userId) {
        return DB::table('table_instagram_access')
            ->where('table_instagram_access.profile_id', $userId)
            ->select('table_instagram_access.*')
            ->first();
    }

    /* Get instagram short token */
    public static function getShortAccessToken($userId) {
        return DB::table('table_instagram_access')
            ->where('table_instagram_access.profile_id', $userId)
            ->where('table_instagram_access.token_type', null)
            ->select('table_instagram_access.*')
            ->first();
    }

    /* Update account info and set long-time token */
    public static function setLongLivedAccessToken($userId, $data) {
        return DB::table('table_instagram_access')
            ->where('table_instagram_access.profile_id', $userId)
            ->where('table_instagram_access.token_type', null)
            ->update([
                'access_token' => $data->access_token,
                'token_type' => $data->token_type,
                'expires_in' => $data->expires_in,
                'updated_at' => Carbon::now()
            ]);
    }

    /* Get post by id */
    public static function getPostById($postId) {
        return DB::table('table_instagram_posts')
            ->where('table_instagram_posts.id', $postId)
            ->select('table_instagram_posts.*')
            ->first();
    }

    /* Get posts array */
    public static function getPosts($shopId) {
        return DB::table('table_instagram_posts')
            ->where('table_instagram_posts.shop_id', $shopId)
            ->select('table_instagram_posts.*')
            ->get();
    }


    /* Get posts with dots array */
    public static function getPostsWithDots($shopId, $status = null, $limit = null) {
        if ($status) {
            $posts = DB::table('table_instagram_posts')
                ->where('table_instagram_posts.shop_id', $shopId)
                ->where('table_instagram_posts.publish_status', $status)
                ->select('table_instagram_posts.*')
                ->get();
        } elseif ($limit){
            $posts = DB::table('table_instagram_posts')
                ->where('table_instagram_posts.shop_id', $shopId)
                ->select('table_instagram_posts.*')
                ->limit($limit)
                ->get();
        } else {
            $posts = DB::table('table_instagram_posts')
                ->where('table_instagram_posts.shop_id', $shopId)
//                ->where('table_instagram_posts.publish_status', $status)
                ->select('table_instagram_posts.*')
                ->limit($limit)
                ->get();
        }

        foreach ($posts as &$post) {
            $post->dots = collect();
            if (DB::table('table_posts_dots')->where(['post_id' => $post->id])->exists()) {
                $dots = DB::table('table_posts_dots')->where(['post_id' => $post->id])->select('table_posts_dots.*')->get();
                foreach ($dots as &$dot) {
                    $dot->serialized_coords = unserialize($dot->serialized_coords);
                    $post->dots->add($dot);
                }
            }
        }

        return $posts;
    }

    /* Cache posts in database */
    public static function savePosts($shopId, $response) {

        foreach ($response as $item) {

            $newPosts = [];
            foreach ($response as $key => $value) {
                $newPosts[] = (int)$value['id'];
            }

            self::deleteRemovedPosts($shopId, $newPosts);

            $itemExist = DB::table('table_instagram_posts')
                ->where('table_instagram_posts.shop_id', $shopId)
                ->where('table_instagram_posts.id_post', $item['id'])
                ->count();

            if ($itemExist > 0)
                DB::table('table_instagram_posts')
                    ->where('table_instagram_posts.shop_id', $shopId)
                    ->where('table_instagram_posts.id_post', $item['id'])
                    ->update([
                        'post_caption' => $item["caption"],
                        'post_media_url' => $item["media_url"],
                        'post_username' => $item["username"],
                        'created_at' => Carbon::now()
                    ]);
            else {
                DB::table('table_instagram_posts')
                    ->insert([
                        'shop_id' => $shopId,
                        'post_caption' => $item["caption"],
                        'post_media_url' => $item["media_url"],
                        'post_username' => $item["username"],
                        'id_post' => $item['id'],
                        'created_at' => Carbon::now()
                    ]);
            }
        }
    }

    /* Remove deleted post from database */
    public static function deleteRemovedPosts($shopId, $newItems) {
        $oldPosts = DB::table('table_instagram_posts')
            ->where('table_instagram_posts.shop_id', $shopId)
            ->select('table_instagram_posts.id_post')
            ->get();

        foreach($oldPosts as $oldPost) {
            if (!in_array($oldPost->id_post, $newItems)) {
                DB::table('table_instagram_posts')
                    ->where('table_instagram_posts.shop_id', $shopId)
                    ->where('table_instagram_posts.id_post', $oldPost->id_post)
                    ->delete();
            }
        }
    }

    /* Display or not display post */
    public static function setPostStatus($id, $status) {
        return DB::table('table_instagram_posts')
            ->where('table_instagram_posts.id', $id)
            ->update([
                'publish_status' => $status
            ]);
    }

    /* Set last update posts time */
    public static function createCrone($shopId, $hours = null) {
        return DB::table('table_instagram_cron')
            ->updateOrInsert(
                [
                    'shop_id' => $shopId
                ],
                [
                    'shop_id' => $shopId,
                    'created_at' => ($hours) ? Carbon::now()->addHours($hours) : null
                ]
            );
    }

    public static function getCroneUpdateTime($shopId) {
        return DB::table('table_instagram_cron')
            ->where('shop_id', $shopId)
            ->first();
    }


}
