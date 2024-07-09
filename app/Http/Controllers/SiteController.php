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

class SiteController extends Controller
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

            return view('site.index', compact('meta_content', 'banners', 'site_data', 'services', 'events', 'blogs'));
        } catch (Throwable $e) {
            DB::rollBack();
            app_error_log('HOME_PAGE_CONTROLLER_ERROR', $e);
            return view('site.error');
        }
    }

    final public function blogs(Request $request): View
    {
        try {
            DB::beginTransaction();
            $meta_content = [
                'title'       => 'Blogs',
                'description' => 'Blogs',
                'keywords'    => 'Blogs',
            ];
            $blogs          = (new Blog())->get_blogs($request);
            $featured_blogs = (new Blog())->get_active_blog(false, true);
            DB::commit();

            return view('site.blogs', compact('meta_content', 'blogs', 'featured_blogs'));
        } catch (Throwable $e) {
            DB::rollBack();
            app_error_log('BLOGS_PAGE_CONTROLLER_ERROR', $e);
            return view('site.error');
        }
    }

    final public function blog(string $slug): View
    {
        try {
            DB::beginTransaction();
            $blog          = (new Blog())->get_blog('slug', $slug);
            $related_blogs = (new Blog())->get_related_blog($blog);
            (new Blog())->increase_click($blog);

            $meta_content = [
                'title'       => $blog->title,
                'description' => $blog->description,
                'keywords'    => $blog->keywords,
            ];
            $related_blogs = (new Blog())->get_active_blog(false, true);
            DB::commit();

            return view('site.blog-detail', compact('meta_content', 'blog', 'related_blogs'));
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e->getMessage());
            app_error_log('BLOG_DETAILS_PAGE_CONTROLLER_ERROR', $e);
            return view('site.error');
        }
    }
}
