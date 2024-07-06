<?php

namespace App\Http\Controllers;

use App\Manager\AccessControl\AccessControlTrait;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Manager\API\Traits\CommonResponse;
use App\Manager\PostManager\Facebook;
use App\Models\Traits\AppActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class PostController extends Controller
{
    use CommonResponse, AppActivityLog, AccessControlTrait;

    public static string $route = 'post';

    /**
     * Display a listing of the resource.
     */
    final public function index(Request $request): View
    {
        $cms_content = [
            'module'       => __('post'),
            'module_url'   => route('post.index'),
            'active_title' => __('List'),
            'button_type'  => 'create',
            'button_title' => __('post Create'),
            'button_url'   => route('post.create'),
        ];
        $posts   = (new Post())->get_posts($request);
        $search  = $request->all();
        $status  = Post::STATUS_LIST;
        $columns = [
            'title'  => 'Title',
            'status' => 'Status',
        ];
        return view(
            'admin.modules.post.index',
            compact('cms_content', 'posts', 'search', 'columns', 'status')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create(): View
    {
        $cms_content = [
            'module'       => __('post'),
            'module_url'   => route('post.index'),
            'active_title' => __('Create'),
            'button_type'  => 'list',
            'button_title' => __('post List'),
            'button_url'   => route('post.index'),
        ];
        $status  = Post::STATUS_LIST;
        return view('admin.modules.post.create', compact('cms_content', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StorePostRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $post = (new Post())->store_post($request);
            (new Facebook())->post($post);
            $original = $post->getOriginal();
            $changed  = $post->getChanges();
            self::activityLog($request, $original, $changed, $post);
            success_alert(__('post created successfully'));
            DB::commit();
            return redirect()->route('post.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('post_CREATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    final public function show(Post $post): View
    {
        $cms_content = [
            'module' => __('post'),
            'module_url'  => route('post.index'),
            'active_title' => __('Details'),
            'button_type'  => 'list',
            'button_title'  => __('post List'),
            'button_url' => route('post.index'),
        ];
        $post->load(['activity_logs', 'created_by', 'updated_by']);
        $status  = Post::STATUS_LIST;
        return view(
            'admin.modules.post.show',
            compact('post', 'cms_content', 'status')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(Post $post): View
    {
        $cms_content = [
            'module' => __('post'),
            'module_url'  => route('post.index'),
            'active_title' => __('Edit'),
            'button_type'  => 'list',
            'button_title'  => __('post List'),
            'button_url' => route('post.index'),
        ];
        return view('admin.modules.post.edit', compact(
            'cms_content',
            'post',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $post->getOriginal();
            (new Post())->update_post($request, $post);
            $changed = $post->getChanges();
            self::activityLog($request, $original, $changed, $post);
            DB::commit();
            success_alert(__('post updated successfully'));
            return redirect()->route('post.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('post_UPDATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Request $request, Post $post): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $post->getOriginal();
            (new Post())->delete_post($post);
            $changed = $post->getChanges();
            self::activityLog($request, $original, $changed, $post);
            DB::commit();
            success_alert(__('post deleted successfully'));
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('post_DELETE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
        }
        return redirect()->back();
    }
}
