<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\Event;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class HomePageController extends Controller
{
    final public function index(): View
    {
        try {
            DB::beginTransaction();
            $meta_content = [
                'title'       => 'Home Page',
                'description' => 'Home Page',
                'keywords'    => 'Home Page',
            ];
            $banners   = (new Banner())->get_banner_by_location([Banner::LOCATION_HOME_TOP]);
            $site_data = Setting::get_setting(['mission', 'vision', 'hero-title', 'hero-subtitle']);
            $services  = (new Service())->get_active_service(true);
            $events    = (new Event())->get_active_event(true);
            $blogs     = (new Blog())->get_active_blog(true);
            DB::commit();

            return view('site.home.index', compact('meta_content', 'banners', 'site_data', 'services', 'events', 'blogs'));
        } catch (Throwable $e) {
            DB::rollBack();
            app_error_log('HOME_PAGE_CONTROLLER_ERROR', $e);
            dd($e->getMessage());
        }
    }
}
