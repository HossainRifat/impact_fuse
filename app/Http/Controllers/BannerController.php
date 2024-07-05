<?php

namespace App\Http\Controllers;

use App\Manager\AccessControl\AccessControlTrait;
use App\Models\Banner;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Manager\API\Traits\CommonResponse;
use App\Models\Traits\AppActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class BannerController extends Controller
{
    use CommonResponse, AppActivityLog, AccessControlTrait;

    public static string $route = 'banner';

    /**
     * Display a listing of the resource.
     */
    final public function index(Request $request): View
    {
        $cms_content = [
            'module'        => __('banner'),
            'module_url'  => route('banner.index'),
            'active_title' => __('List'),
            'button_type'  => 'create',
            'button_title'  => __('banner Create'),
            'button_url' => route('banner.create'),
        ];
        $banners   = (new Banner())->get_banners($request);
        $search    = $request->all();
        $types     = Banner::TYPE_LIST;
        $locations = Banner::LOCATION_LIST;
        $status    = Banner::STATUS_LIST;
        $columns   = [
            'name'       => 'Name',
            'sort_order' => 'Sort Order',
            'status'     => 'Status',
        ];
        return view(
            'admin.modules.banner.index',
            compact('cms_content', 'banners', 'search', 'columns', 'types', 'locations', 'status')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create(): View
    {
        $cms_content = [
            'module' => __('banner'),
            'module_url'  => route('banner.index'),
            'active_title' => __('Create'),
            'button_type'  => 'list',
            'button_title'  => __('banner List'),
            'button_url' => route('banner.index'),
        ];
        $types     = Banner::TYPE_LIST;
        $locations = Banner::LOCATION_LIST;
        $status    = Banner::STATUS_LIST;
        return view('admin.modules.banner.create', compact('cms_content', 'types', 'locations', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreBannerRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $banner = (new Banner())->store_banner($request);
            $original = $banner->getOriginal();
            $changed = $banner->getChanges();
            self::activityLog($request, $original, $changed, $banner);
            success_alert(__('banner created successfully'));
            DB::commit();
            return redirect()->route('banner.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('banner_CREATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    final public function show(Banner $banner): View
    {
        $cms_content = [
            'module' => __('banner'),
            'module_url'  => route('banner.index'),
            'active_title' => __('Details'),
            'button_type'  => 'list',
            'button_title'  => __('banner List'),
            'button_url' => route('banner.index'),
        ];
        $banner->load(['activity_logs', 'created_by', 'updated_by']);
        $types     = Banner::TYPE_LIST;
        $locations = Banner::LOCATION_LIST;
        $status    = Banner::STATUS_LIST;
        return view(
            'admin.modules.banner.show',
            compact('banner', 'cms_content', 'types', 'locations', 'status')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(Banner $banner): View
    {
        $cms_content = [
            'module' => __('banner'),
            'module_url'  => route('banner.index'),
            'active_title' => __('Edit'),
            'button_type'  => 'list',
            'button_title'  => __('banner List'),
            'button_url' => route('banner.index'),
        ];
        $types     = Banner::TYPE_LIST;
        $locations = Banner::LOCATION_LIST;
        $status    = Banner::STATUS_LIST;
        return view('admin.modules.banner.edit', compact(
            'cms_content',
            'banner',
            'types',
            'locations',
            'status'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateBannerRequest $request, Banner $banner): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $banner->getOriginal();
            (new Banner())->update_banner($request, $banner);
            $changed = $banner->getChanges();
            self::activityLog($request, $original, $changed, $banner);
            DB::commit();
            success_alert(__('banner updated successfully'));
            return redirect()->route('banner.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('banner_UPDATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Request $request, Banner $banner): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $banner->getOriginal();
            (new Banner())->delete_banner($banner);
            $changed = $banner->getChanges();
            self::activityLog($request, $original, $changed, $banner);
            DB::commit();
            success_alert(__('banner deleted successfully'));
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('banner_DELETE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
        }
        return redirect()->back();
    }
}
