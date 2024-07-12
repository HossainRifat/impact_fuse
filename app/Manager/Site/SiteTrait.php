<?php

namespace App\Manager\Site;

use App\Manager\Constants\GlobalConstant;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

trait SiteTrait
{
    public function get_site_data()
    {
        if (Cache::has('site_data')) {
            return Cache::get('site_data');
        }

        $required_data = [
            'footer-about-us',
            'title-suffix',
            'facebook-link',
            'instagram-link',
            'x-link',
            'linkedin-link',
            'youtube-link',
        ];

        $site_data = (new Setting())->get_setting($required_data);
        Cache::put('site_data', $site_data, GlobalConstant::CACHE_EXPIRY);

        return $site_data;
    }
}
