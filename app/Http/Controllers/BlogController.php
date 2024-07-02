<?php

namespace App\Http\Controllers;

use App\Manager\AccessControl\AccessControlTrait;
use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Manager\API\Traits\CommonResponse;
use App\Models\BlogCategory;
use App\Models\Traits\AppActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class BlogController extends Controller
{
    use CommonResponse, AppActivityLog, AccessControlTrait;

    public static string $route = 'blog';

    /**
     * Display a listing of the resource.
     */
    final public function index(Request $request): View
    {

        $cms_content = [
            'module'       => __('Blog'),
            'module_url'   => route('blog.index'),
            'active_title' => __('List'),
            'button_type'  => 'create',
            'button_title' => __('Blog Create'),
            'button_url'   => route('blog.create'),
        ];
        $blogs              = (new Blog())->get_blogs($request);
        $search             = $request->all();
        $columns            = [
            'title'      => 'Title',
            'status'     => 'Status',
            'created_at' => 'Created At',
        ];
        $status          = Blog::STATUS_LIST;
        $is_featured     = Blog::IS_FEATURED;
        $is_show_on_home = Blog::IS_SHOW_ON_HOME;
        return view('admin.modules.blog.index', compact('cms_content', 'blogs', 'search', 'columns', 'status', 'is_featured', 'is_show_on_home'));
    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create(): View
    {

        $cms_content = [
            'module'       => __('Blog'),
            'module_url'   => route('blog.index'),
            'active_title' => __('Blog Create'),
            'button_type'  => 'list',
            'button_title' => __('Blog List'),
            'button_url'   => route('blog.index'),
        ];
        $status      = Blog::STATUS_LIST;
        $categories  = (new BlogCategory())->get_categories_assoc();
        return view('admin.modules.blog.create', compact('cms_content', 'status', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreBlogRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $blog     = (new Blog())->store_blog($request);
            $original = $blog->getOriginal();
            $changed  = $blog->getChanges();
            self::activityLog($request, $original, $changed, $blog);
            success_alert('blog created successfully');
            DB::commit();
            return redirect()->route('blog.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            dd($throwable->getMessage());
            app_error_log('blog_CREATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    final public function show(Blog $blog): View
    {

        $cms_content = [
            'module'       => __('Blog'),
            'module_url'   => route('blog.index'),
            'active_title' => __('Blog Details'),
            'button_type'  => 'list',
            'button_title' => __('Blog List'),
            'button_url'   => route('blog.index'),
        ];
        $blog->load(['activity_logs', 'created_by', 'updated_by', 'seo', 'photo', 'categories', 'activity_logs.created_by', 'activity_logs.updated_by']);
        $seo = $blog->seo;

        return view('admin.modules.blog.show', compact('blog', 'cms_content', 'seo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(Blog $blog): View
    {
        $cms_content = [
            'module'       => __('Blog'),
            'module_url'   => route('blog.index'),
            'active_title' => __('Blog Edit'),
            'button_type'  => 'list',
            'button_title' => __('Blog List'),
            'button_url'   => route('blog.index'),
        ];

        $status     = Blog::STATUS_LIST;
        $categories = (new BlogCategory())->get_categories_assoc();
        $seo        = $blog->seo;
        return view('admin.modules.blog.edit', compact('cms_content', 'blog', 'status', 'categories', 'seo'));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateBlogRequest $request, Blog $blog): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $blog->getOriginal();
            (new Blog())->update_blog($request, $blog);
            $changed = $blog->getChanges();
            self::activityLog($request, $original, $changed, $blog);
            DB::commit();
            success_alert('blog updated successfully');
            return redirect()->route('blog.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('blog_UPDATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Request $request, Blog $blog): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $blog->getOriginal();
            (new Blog())->delete_blog($blog);
            $changed = $blog->getChanges();
            self::activityLog($request, $original, $changed, $blog);
            DB::commit();
            success_alert('blog deleted successfully');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('blog_DELETE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
        }
        return redirect()->back();
    }


    public function site_index(Request $request)
    {
        try {
            DB::beginTransaction();
            $blogs                = (new Blog())->get_blogs($request, null, false, true);
            $this->status_message = 'Blog data fetched successfully';
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('Blog_data_fetched_failed', $throwable, 'error');
        }
    }

    final public function site_show(string $slug)
    {
        try {
            DB::beginTransaction();
            $blog                = (new Blog())->get_blog('slug', $slug);
            $blog->increase_click($blog);
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('Blog_data_fetched_failed', $throwable, 'error');
        }
    }
}
