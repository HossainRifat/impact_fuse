<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\Event;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;
use App\Manager\Site\SiteTrait;
use App\Models\Page;

class SiteController extends Controller
{
    use SiteTrait;

    private $site_content = [];

    public function __construct()
    {
        $this->site_content = $this->get_site_data();
    }

    final public function index(): View
    {
        try {
            DB::beginTransaction();
            $meta_content = [
                'title'       => 'Home',
                'description' => 'Home Page',
                'keywords'    => 'Home Page',
            ];
            $site_content = $this->site_content;
            $banners      = (new Banner())->get_banner_by_location([Banner::LOCATION_HOME_TOP]);
            $site_data    = Setting::get_setting(['mission', 'vision', 'hero-title', 'hero-subtitle']);
            $services     = (new Service())->get_active_service(true);
            $events       = (new Event())->get_active_event(true);
            $blogs        = (new Blog())->get_active_blog(true);
            DB::commit();
            return view('site.index', compact('meta_content', 'banners', 'site_data', 'services', 'events', 'blogs', 'site_data', 'site_content'));
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
        
            $site_content   = $this->site_content;
            $blogs          = (new Blog())->get_blogs($request);
            $featured_blogs = (new Blog())->get_active_blog(false, true);
            DB::commit();

            return view('site.blogs', compact('meta_content', 'blogs', 'featured_blogs', 'site_content'));
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
            $site_content  = $this->site_content;
            $related_blogs = (new Blog())->get_active_blog(false, true);
            DB::commit();

            return view('site.blog-detail', compact('meta_content', 'blog', 'related_blogs', 'site_content'));
        } catch (Throwable $e) {
            DB::rollBack();
            app_error_log('BLOG_DETAILS_PAGE_CONTROLLER_ERROR', $e);
            return view('site.error');
        }
    }

    final public function events(Request $request): View
    {
        try {
            DB::beginTransaction();
            $meta_content = [
                'title'       => 'Events',
                'description' => 'Events',
                'keywords'    => 'Events',
            ];
            $site_content    = $this->site_content;
            $events          = (new Event())->get_events($request, null, null, true);
            $featured_events = (new Event())->get_special_events(true, false, 8);
            $upcoming_events = (new Event())->get_upcoming_events(5);
            DB::commit();

            return view('site.events', compact('meta_content', 'events', 'featured_events', 'upcoming_events', 'site_content'));
        } catch (Throwable $e) {
            DB::rollBack();
            app_error_log('EVENTS_PAGE_CONTROLLER_ERROR', $e);
            return view('site.error');
        }
    }

    final public function event(string $slug): View
    {
        try {
            DB::beginTransaction();
            $event          = (new Event())->get_event('slug', $slug);
            $related_events = (new Event())->get_related_event($event);
            (new Event())->increase_click($event);

            $meta_content = [
                'title'       => $event->title,
                'description' => $event->description,
                'keywords'    => $event->keywords,
            ];
            $site_content   = $this->site_content;
            $related_events = (new Event())->get_special_events(true, false, 8);
            DB::commit();

            return view('site.event', compact('meta_content', 'event', 'related_events', 'site_content'));
        } catch (Throwable $e) {
            DB::rollBack();
            app_error_log('EVENT_DETAILS_PAGE_CONTROLLER_ERROR', $e);
            return view('site.error');
        }
    }

    final public function members(): View
    {
        try {
            DB::beginTransaction();
            $meta_content = [
                'title'       => 'Members',
                'description' => 'Members',
                'keywords'    => 'Members',
            ];

            $site_content = $this->site_content;
            $members      = (new User())->get_active_members();
            $site_data    = Setting::get_setting(['member-page']);
            DB::commit();

            // dd($members, $site_data);

            return view('site.members', compact('meta_content', 'members', 'site_data', 'site_content'));
        } catch (Throwable $e) {
            DB::rollBack();
            app_error_log('MEMBERS_PAGE_CONTROLLER_ERROR', $e);
            return view('site.error');
        }
    }

    final public function page(string $slug): View
    {
        try {
            DB::beginTransaction();
            $page = (new Page())->get_by_slug($slug);
            if (!$page) {
                return view('site.error');
            }
            $site_content = $this->site_content;
            $meta_content = [
                'title'       => $page->seo?->title,
                'description' => $page->seo?->description,
                'keywords'    => $page->seo?->keywords,
            ];
            DB::commit();

            return view('site.page', compact('meta_content', 'page', 'site_content'));
        } catch (Throwable $e) {
            DB::rollBack();
            app_error_log('PAGE_PAGE_CONTROLLER_ERROR', $e);
            return view('site.error');
        }
    }
}
