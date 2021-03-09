<?php


namespace App\Classes;


class Shopify
{
    public static function loadShopProducts($shop) {
        $products = $shop->api()->rest('GET', '/admin/products.json');
        return $products;
    }

    public static function getMainThemeId($shop) {

        $themes = $shop->api()->rest('GET', '/admin/themes.json');

        $activeThemeId = "";
        foreach ($themes['body']->container['themes'] as $theme) {
            if ($theme['role'] == "main")
                $activeThemeId = $theme['id'];
        }

        return $activeThemeId;
    }

    public static function setNewSection($shop, $themeId, $array) {
        return $shop->api()->rest('PUT', '/admin/themes/'.$themeId.'/assets.json', $array);
    }

    public static function setNewScriptTag($shop, $array) {
        return $shop->api()->rest('POST', '/admin/script_tags.json', $array);
    }

    public static function removeScriptTag($shop, $id) {
        return $shop->api()->rest('DELETE', "/admin/script_tags/".$id.".json");
    }

}
