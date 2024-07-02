<?php

namespace App\Http\Controllers;

use App\Manager\AccessControl\AccessControlTrait;
use App\Models\BlogCategory;
use App\Http\Requests\StoreBlogCategoryRequest;
use App\Http\Requests\UpdateBlogCategoryRequest;
use App\Manager\API\Traits\CommonResponse;
use App\Models\Traits\AppActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class BlogCategoryController extends Controller
{
    use CommonResponse, AppActivityLog, AccessControlTrait;

    public static string $route = 'blog-category';

    /**
     * Display a listing of the resource.
     */
    final public function index(Request $request): View
    {
        $cms_content = [
            'module'       => __('Blog Category'),
            'module_url'   => route('blog-category.index'),
            'active_title' => __('List'),
            'button_type'  => 'create',
            'button_title' => __('Blog Category Create'),
            'button_url'   => route('blog-category.create'),
        ];
        $categories   = (new BlogCategory())->get_categories($request);
        $search      = $request->all();
        $columns     = [
            'name'       => 'Name',
            'status'     => 'Status',
            'parent_id'     => 'Parent',
        ];
        $status      = BlogCategory::STATUS_LIST;
        return view('admin.modules.blog-category.index', compact('cms_content', 'categories', 'search', 'columns', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create(): View
    {

        $cms_content = [
            'module'        => __('Blog Category'),
            'module_url'  => route('blog-category.index'),
            'active_title' =>  __('Blog Category Create'),
            'button_type'  => 'list',
            'button_title'  => __('Blog Category List'),
            'button_url' => route('blog-category.index'),
        ];

        $categories = (new BlogCategory())->get_categories_assoc();
        $status     = BlogCategory::STATUS_LIST;
        return view('admin.modules.blog-category.create', compact('cms_content', 'categories', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreBlogCategoryRequest $request): RedirectResponse
    {

        try {
            DB::beginTransaction();
            $blogCategory = (new BlogCategory())->create_category($request);
            $original = $blogCategory->getOriginal();
            $changed = $blogCategory->getChanges();
            self::activityLog($request, $original, $changed, $blogCategory);
            success_alert('Blog category created successfully');
            DB::commit();
            return redirect()->route('blog-category.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            dd($throwable->getMessage());
            app_error_log('Blog Category_CREATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    final public function show(BlogCategory $blog_category): View
    {
        $cms_content = [
            'module'        => __('Blog Category'),
            'module_url'  => route('blog-category.index'),
            'active_title' =>  __('Details'),
            'button_type'  => 'list',
            'button_title'  => __('Blog Category List'),
            'button_url' => route('blog-category.index'),
        ];
        $blog_category->load(['activity_logs', 'created_by', 'updated_by', 'parent', 'seo', 'activity_logs.created_by', 'activity_logs.updated_by']);
        $seo = $blog_category->seo;

        return view('admin.modules.blog-category.show', compact('blog_category', 'cms_content', 'seo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(BlogCategory $blog_category): View
    {
        $cms_content = [
            'module'        => __('Blog Category'),
            'module_url'  => route('blog-category.index'),
            'active_title' =>  __('Edit'),
            'button_type'  => 'list',
            'button_title'  => __('Blog Category List'),
            'button_url' => route('blog-category.index'),
        ];

        $categories = (new BlogCategory())->get_categories_assoc();
        $status     = BlogCategory::STATUS_LIST;
        $seo        = $blog_category->seo;
        return view('admin.modules.blog-category.edit', compact('cms_content', 'blog_category', 'categories', 'status', 'seo'));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateBlogCategoryRequest $request, BlogCategory $blog_category): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $blog_category->getOriginal();
            (new BlogCategory())->update_category($request, $blog_category);
            $changed = $blog_category->getChanges();
            self::activityLog($request, $original, $changed, $blog_category);
            DB::commit();
            success_alert('Blog Category updated successfully');
            return redirect()->route('blog-category.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('Blog Category_UPDATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Request $request, BlogCategory $blog_category): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $blog_category->getOriginal();
            (new BlogCategory())->delete_category($blog_category);
            $changed = $blog_category->getChanges();
            self::activityLog($request, $original, $changed, $blog_category);
            DB::commit();
            success_alert('Blog Category deleted successfully');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('Blog Category_DELETE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
        }
        return redirect()->back();
    }
}
