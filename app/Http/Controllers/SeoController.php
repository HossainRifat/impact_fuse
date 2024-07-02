<?php

namespace App\Http\Controllers;

use App\Manager\AccessControl\AccessControlTrait;
use App\Models\Seo;
use App\Http\Requests\StoreSeoRequest;
use App\Http\Requests\UpdateSeoRequest;
use App\Manager\API\Traits\CommonResponse;
use App\Models\Traits\AppActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class SeoController extends Controller
{
    use CommonResponse, AppActivityLog, AccessControlTrait;

    public static string $route = 'seo';

    /**
     * Display a listing of the resource.
     */
    final public function index(Request $request):View
    {
        $cms_content = [
            'module'        => __('seo'),
            'module_url'  => route('seo.index'),
            'active_title' => __('List'),
            'button_type'  => 'create',
            'button_title'  => __('seo Create'),
            'button_url' => route('seo.create'),
        ];
        $seos   = (new Seo())->get_seo($request);
        $search      = $request->all();
        $columns     = [
            'name'       => 'Name',
            'sort_order' => 'Sort Order',
            'status'     => 'Status',
            ];
        return view('admin.modules.seo.index',
        compact('cms_content', 'seos', 'search', 'columns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create():View
    {
        $cms_content = [
            'module' => __('seo'),
            'module_url'  => route('seo.index'),
            'active_title' => __('Create'),
            'button_type'  => 'list',
            'button_title'  => __('seo List'),
            'button_url' => route('seo.index'),
        ];
        return view('admin.modules.seo.create', compact('cms_content'));
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreSeoRequest $request):RedirectResponse
    {
        try {
           DB::beginTransaction();
           $seo = (new Seo())->store_seo($request);
           $original = $seo->getOriginal();
           $changed = $seo->getChanges();
           self::activityLog($request, $original, $changed, $seo);
           success_alert(__('seo created successfully'));
           DB::commit();
           return redirect()->route('seo.index');
       } catch (Throwable $throwable) {
           DB::rollBack();
           app_error_log('seo_CREATE_FAILED', $throwable, 'error');
           failed_alert($throwable->getMessage());
           return redirect()->back();
       }
    }

    /**
     * Display the specified resource.
     */
    final public function show(Seo $seo):View
    {
        $cms_content = [
            'module' => __('seo'),
            'module_url'  => route('seo.index'),
            'active_title' => __('Details'),
            'button_type'  => 'list',
            'button_title'  => __('seo List'),
            'button_url' => route('seo.index'),
        ];
        $seo->load(['activity_logs', 'created_by', 'updated_by']);

        return view('admin.modules.seo.show',
                   compact('seo', 'cms_content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(Seo $seo):View
    {
        $cms_content = [
            'module' => __('seo'),
            'module_url'  => route('seo.index'),
            'active_title' => __('Edit'),
            'button_type'  => 'list',
            'button_title'  => __('seo List'),
            'button_url' => route('seo.index'),
        ];
        return view('admin.modules.seo.edit', compact(
                    'cms_content',
                    'seo',
                ));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateSeoRequest $request, Seo $seo):RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $seo->getOriginal();
            (new Seo())->update_seo($request, $seo);
            $changed = $seo->getChanges();
            self::activityLog($request, $original, $changed, $seo);
            DB::commit();
            success_alert(__('seo updated successfully'));
            return redirect()->route('seo.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('seo_UPDATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Request $request, Seo $seo):RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $seo->getOriginal();
            (new Seo())->delete_seo($seo);
            $changed = $seo->getChanges();
            self::activityLog($request, $original, $changed, $seo);
            DB::commit();
            success_alert(__('seo deleted successfully'));
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('seo_DELETE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            }
        return redirect()->back();
    }
}
