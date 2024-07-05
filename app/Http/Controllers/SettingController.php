<?php

namespace App\Http\Controllers;

use App\Manager\AccessControl\AccessControlTrait;
use App\Models\Setting;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Manager\API\Traits\CommonResponse;
use App\Models\Traits\AppActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class SettingController extends Controller
{
    use CommonResponse, AppActivityLog, AccessControlTrait;

    public static string $route = 'setting';

    /**
     * Display a listing of the resource.
     */
    final public function index(Request $request): View
    {
        $cms_content = [
            'module'       => __('setting'),
            'module_url'   => route('setting.index'),
            'active_title' => __('List'),
            'button_type'  => 'create',
            'button_title' => __('setting Create'),
            'button_url'   => route('setting.create'),
        ];
        $settings   = (new Setting())->get_settings($request, Setting::TYPE_WEB_DECORATION);
        $search      = $request->all();
        $status      = Setting::STATUS_LIST;
        $columns     = [
            'key'    => 'Key',
            'status' => 'Status',
        ];
        return view(
            'admin.modules.setting.index',
            compact('cms_content', 'settings', 'search', 'columns', 'status')
        );
    }

    /**
     * Display a listing of the resource.
     */
    final public function index_credentials(Request $request): View
    {
        $cms_content = [
            'module'       => __('setting'),
            'module_url'   => route('setting.index'),
            'active_title' => __('List'),
            'button_type'  => 'create',
            'button_title' => __('setting Create'),
            'button_url'   => route('setting.create'),
        ];
        $settings = (new Setting())->get_settings($request, Setting::TYPE_WEB_CREDENTIALS);
        $search   = $request->all();
        $status   = Setting::STATUS_LIST;
        $columns  = [
            'key'    => 'Key',
            'status' => 'Status',
        ];
        return view(
            'admin.modules.setting.index',
            compact('cms_content', 'settings', 'search', 'columns', 'status')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create(): View
    {
        $cms_content = [
            'module'       => __('setting'),
            'module_url'   => route('setting.index'),
            'active_title' => __('Create'),
            'button_type'  => 'list',
            'button_title' => __('setting List'),
            'button_url'   => route('setting.index'),
        ];
        $status = Setting::STATUS_LIST;
        $types  = Setting::TYPE_LIST;
        return view('admin.modules.setting.create', compact('cms_content', 'status', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreSettingRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $setting = (new Setting())->store_setting($request);
            $original = $setting->getOriginal();
            $changed = $setting->getChanges();
            self::activityLog($request, $original, $changed, $setting);
            success_alert(__('setting created successfully'));
            DB::commit();
            return redirect()->route('setting.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('setting_CREATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    final public function show(Setting $setting): View
    {
        $cms_content = [
            'module'       => __('setting'),
            'module_url'   => route('setting.index'),
            'active_title' => __('Details'),
            'button_type'  => 'list',
            'button_title' => __('setting List'),
            'button_url'   => route('setting.index'),
        ];
        $setting->load(['activity_logs', 'created_by', 'updated_by']);

        return view(
            'admin.modules.setting.show',
            compact('setting', 'cms_content')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(Setting $setting): View
    {
        $cms_content = [
            'module' => __('setting'),
            'module_url'  => route('setting.index'),
            'active_title' => __('Edit'),
            'button_type'  => 'list',
            'button_title'  => __('setting List'),
            'button_url' => route('setting.index'),
        ];
        $status = Setting::STATUS_LIST;
        $types  = Setting::TYPE_LIST;
        return view('admin.modules.setting.edit', compact(
            'cms_content',
            'setting',
            'status',
            'types'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateSettingRequest $request, Setting $setting): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $setting->getOriginal();
            (new Setting())->update_setting($request, $setting);
            $changed = $setting->getChanges();
            self::activityLog($request, $original, $changed, $setting);
            DB::commit();
            success_alert(__('setting updated successfully'));
            return redirect()->route('setting.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('setting_UPDATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Request $request, Setting $setting): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $setting->getOriginal();
            (new Setting())->delete_setting($setting);
            $changed = $setting->getChanges();
            self::activityLog($request, $original, $changed, $setting);
            DB::commit();
            success_alert(__('setting deleted successfully'));
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('setting_DELETE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
        }
        return redirect()->back();
    }
}
