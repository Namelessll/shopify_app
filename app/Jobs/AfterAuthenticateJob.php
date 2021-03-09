<?php

namespace App\Jobs;

use App\Classes\Shopify;
use App\Models\InstagramModel;
use App\Models\UserModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Classes\Instagram\libs\CacheHandler;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AfterAuthenticateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        UserModel::updateUser(Auth::id(), ['plan_id' => 1]);
        InstagramModel::createCrone(Auth::id());
        $this->createSection(Auth::user());
        $this->createScriptTag(Auth::user());

        Cache::add('user_id', Auth::id());
        $cacheHandler = new CacheHandler(Auth::id());
    }

    private function createSection($user) {
        $activeThemeId = Shopify::getMainThemeId($user);

        $section = Storage::disk('local')->get('instagram-shopify-slider.liquid');
        $array = array('asset' => array('key' => 'sections/instagram-shopify-slider.liquid', 'value' => $section));

        return Shopify::setNewSection(Auth::user(), $activeThemeId, $array);
    }

    private function createScriptTag($user) {
        $array = array(
            'script_tag' => array(
                'event' => 'onload',
                'src' => 'https://7910c053feef.ngrok.io/js/instagram-script.js',
            )
        );

        return Shopify::setNewScriptTag($user, $array);
    }

}
