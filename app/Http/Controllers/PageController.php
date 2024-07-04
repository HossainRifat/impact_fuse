<?php

namespace App\Http\Controllers;

use App\Manager\AccessControl\AccessControlTrait;
use App\Models\Page;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Manager\API\Traits\CommonResponse;
use App\Models\Traits\AppActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class PageController extends Controller
{
    use CommonResponse, AppActivityLog, AccessControlTrait;

    public static string $route = 'page';

    /**
     * Display a listing of the resource.
     */
    final public function index(Request $request): View
    {
        $cms_content = [
            'module'       => __('page'),
            'module_url'   => route('page.index'),
            'active_title' => __('List'),
            'button_type'  => 'create',
            'button_title' => __('page Create'),
            'button_url'   => route('page.create'),
        ];
        $pages   = (new Page())->get_pages($request);
        $search  = $request->all();
        $status  = Page::STATUS_LIST;
        $columns = [
            'name'       => 'Name',
            'sort_order' => 'Sort Order',
            'status'     => 'Status',
        ];
        return view(
            'admin.modules.page.index',
            compact('cms_content', 'pages', 'search', 'columns', 'status')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create(): View
    {
        $cms_content = [
            'module'       => __('page'),
            'module_url'   => route('page.index'),
            'active_title' => __('Create'),
            'button_type'  => 'list',
            'button_title' => __('page List'),
            'button_url'   => route('page.index'),
        ];
        $status = Page::STATUS_LIST;
        return view('admin.modules.page.create', compact('cms_content', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StorePageRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $page = (new Page())->store_page($request);
            $original = $page->getOriginal();
            $changed = $page->getChanges();
            self::activityLog($request, $original, $changed, $page);
            success_alert(__('page created successfully'));
            DB::commit();
            return redirect()->route('page.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('page_CREATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    final public function show(Page $page): View
    {
        $cms_content = [
            'module' => __('page'),
            'module_url'  => route('page.index'),
            'active_title' => __('Details'),
            'button_type'  => 'list',
            'button_title'  => __('page List'),
            'button_url' => route('page.index'),
        ];
        $page->load(['activity_logs', 'created_by', 'updated_by', 'seo']);
        $seo = $page->seo;
        return view(
            'admin.modules.page.show',
            compact('page', 'cms_content', 'seo')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(Page $page): View
    {
        $cms_content = [
            'module' => __('page'),
            'module_url'  => route('page.index'),
            'active_title' => __('Edit'),
            'button_type'  => 'list',
            'button_title'  => __('page List'),
            'button_url' => route('page.index'),
        ];
        $status = Page::STATUS_LIST;
        $seo = $page->seo;
        return view('admin.modules.page.edit', compact(
            'cms_content',
            'page',
            'status',
            'seo'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $page->getOriginal();
            (new Page())->update_page($request, $page);
            $changed = $page->getChanges();
            self::activityLog($request, $original, $changed, $page);
            DB::commit();
            success_alert(__('page updated successfully'));
            return redirect()->route('page.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('page_UPDATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Request $request, Page $page): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $page->getOriginal();
            (new Page())->delete_page($page);
            $changed = $page->getChanges();
            self::activityLog($request, $original, $changed, $page);
            DB::commit();
            success_alert(__('page deleted successfully'));
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('page_DELETE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
        }
        return redirect()->back();
    }
}
