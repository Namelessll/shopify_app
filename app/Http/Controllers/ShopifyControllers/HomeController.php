<?php

namespace App\Http\Controllers\ShopifyControllers;

use App\Classes\Instagram\libs\CacheHandler;
use App\Classes\Shopify;
use App\Http\Controllers\Controller;
use App\Classes\Instagram\libs\Connect;
use App\Models\ProductsModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Classes\Instagram\libs\Helper;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    private $instagramConnectUrl;
    public function __construct() {
        $instagramConnect = new Connect();
        $this->instagramConnectUrl = $instagramConnect->returnConnectRoute();
    }

    public function viewHomePage() {

        $instagramHelper = new Helper(Auth::id());
        ProductsModel::saveProducts(Auth::id(), Shopify::loadShopProducts(Auth::user()));
        $data['title'] = "Dashboard";
        $data['instagramConnect'] = $this->instagramConnectUrl;
        $data['posts'] = $instagramHelper->getPosts();
        $data['status'] = $instagramHelper->healthCheckConnection();
        $data['success'] = 'Account connected';
        $data['shop'] = new \stdClass();
        $data['shop']->availableViews = $instagramHelper->getAvailableViews();
        $data['shop']->planId = UserModel::getUserField(Auth::id(), 'plan_id')->plan_id;

        return view('home', $data);
    }
}
