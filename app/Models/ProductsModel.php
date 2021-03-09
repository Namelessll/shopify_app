<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductsModel extends Model
{
    use HasFactory;
    /* Save shop products to cache */
    public static function saveProducts($id, $prods)
    {
//        dd($id, $prods);
        Cache::forget("product_user_$id");
        return Cache::forever("product_user_$id", $prods['body']->container['products']);
    }

    /* Load products from cache */
    public static function getProducts($id) {
        if (Cache::has("product_user_$id"))
            return Cache::get("product_user_$id");
        else
            return [];
    }

    /* Load product info from cache by id */
    public static function getProductInfoById($id, $productId) {
        $products = Cache::get("product_user_$id");

        foreach($products as $product) {
            if ($product['id'] == $productId) {
                return $product;
            }
        }

        return [];
    }

    /* Save coords dot tag */
    public static function saveDot($idPost, $coords, $data) {
//        dd($data);
        $id = DB::table('table_posts_dots')
            ->insertGetId([
                'post_id' => $idPost,
                'serialized_coords' => serialize($coords),
                'product_id' => $data['id'],
                'product_name' => $data['title'],
                'product_image' => $data['image']['src'] ?? null,
                'product_handle' => $data['handle'],
                'product_price' => collect($data['variants'])->min('price'),
                'created_at' => Carbon::now()
            ]);

        return DB::table('table_posts_dots')
            ->where('table_posts_dots.id', $id)
            ->select('table_posts_dots.*')
            ->get();
    }

    /* Get tag dots for post */
    public static function getDots($idPost) {
        $query = DB::table('table_posts_dots')
            ->where('table_posts_dots.post_id', $idPost)
            ->select('table_posts_dots.*')
            ->get();

        foreach($query as $key => $it) {
            $query[$key]->serialized_coords = unserialize($it->serialized_coords);
        }

        return $query;
    }

    /* Remove dot from DB*/
    public static function unsetDot($idDot) {
        DB::table('table_posts_dots')
            ->where('table_posts_dots.id', $idDot)
            ->delete();

        return $idDot;
    }

    /* Change coords for dot*/
    public static function updateDot($idDot, $coords) {
        return DB::Table('table_posts_dots')
            ->where('table_posts_dots.id', $idDot)
            ->update([
                'serialized_coords' => serialize($coords)
            ]);
    }
}
