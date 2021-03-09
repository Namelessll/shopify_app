<?php

namespace App\Http\Controllers;

use App\Classes\Instagram\Handler;
use App\Models\InstagramModel;
use App\Models\ProductsModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Throwable;

class APIController extends Controller
{
    public function popupData(Request $request) {
        $postId = $request->get('post');
        $dots = ProductsModel::getDots($postId);
//        $postUsername = InstagramModel::getPostById($postId);
//        $pic_user = Handler::getInstance()->getAccountData($postUsername->post_username)['graphql']['user']['profile_pic_url'];

        return json_encode(
            array(
                'post' => InstagramModel::getPostById($postId),
                'dots' => $dots,
                'pic_user' => $pic_user ?? 'null'
            )
        );
    }

    public function publishItem(Request $request) {
        $idPost = json_decode($request->getContent(), true)['id'];

        try {
            $result = InstagramModel::setPostStatus($idPost, true);
        } catch(Throwable $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal Server Error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($result)
            return response()->json([
                'status' => 200,
                'message' => 'OK'
            ], Response::HTTP_OK);
        else
            return response()->json([
                'status' => 304,
                'message' => 'Not Modified'
            ], Response::HTTP_NOT_MODIFIED);
    }

    /* Set post as unpublished */
    public function unPublishItem(Request $request) {
        $idPost = json_decode($request->getContent(), true)['id'];

        try {
            $result = InstagramModel::setPostStatus($idPost, false);
        } catch(Throwable $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal Server Error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($result)
            return response()->json([
                'status' => 200,
                'message' => 'OK'
            ], Response::HTTP_OK);
        else
            return response()->json([
                'status' => 304,
                'message' => 'Not Modified'
            ], Response::HTTP_NOT_MODIFIED);
    }

    /* Searching */
    public function getProducts(Request $request) {
        $products = ProductsModel::getProducts($request->get('shop_id'));
        $filtredArray = [];

        if (empty($request->get('query'))) {
            $count = 0;
            foreach($products as $product) {
                if ($count < 20 ) {
                    $filtredArray[] = $product;
                    $count++;
                }
                else
                    break;
            }
            return json_encode($filtredArray);
        }

        //dd($products);
        foreach($products as $product) {
            if (mb_strpos(strtolower($product['title']), strtolower($request->get('query'))) !== false) {
                $filtredArray[] = $product;
            }
        }

        return json_encode($filtredArray);
    }

    public function setDot(Request $request) {
        $requestDecode = json_decode($request->getContent());

        $productData = ProductsModel::getProductInfoById($requestDecode->shop_id, $requestDecode->id_product);
        $coords = [
            'top' => $requestDecode->coord_top,
            'left' => $requestDecode->coord_left,
        ];

        $response = ProductsModel::saveDot($requestDecode->id, $coords, $productData);


        return json_encode($response);
    }

    public function unsetDot(Request $request) {
        $request = json_decode($request->getContent());
        $response = ProductsModel::unsetDot($request->id_post_del);

        return json_encode($response);
    }

    public function updateDot(Request $request) {
        $request = json_decode($request->getContent());
        $coords = [
            'top' => $request->coord_top,
            'left' => $request->coord_left,
        ];

        $response = ProductsModel::updateDot($request->id, $coords);

        return json_encode($response);
    }

//    public function getPosts(Request $request) {
//        $shopId = Theme::getInstance()->getUserIdByHost($request->get('host'))[0]->id ?? [];
//        CacheHandler::view($shopId);
//        return InstagramModel::getPostsWithDots($shopId, $request['posts_count']);
//    }
}
