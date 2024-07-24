<?php

namespace App\Http\Controllers;

use App\Manager\AccessControl\AccessControlTrait;
use App\Models\SiteVisit;
use App\Http\Requests\StoreSiteVisitRequest;
use App\Http\Requests\UpdateSiteVisitRequest;
use App\Manager\API\Traits\CommonResponse;
use App\Models\Traits\AppActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class SiteVisitController extends Controller
{
    use CommonResponse, AppActivityLog, AccessControlTrait;

    public static string $route = 'siteVisit';

    /**
     * Display a listing of the resource.
     */
    final public function index(Request $request):View
    {
        $cms_content = [
            'module'       => __('siteVisit'),
            'module_url'   => route('siteVisit.index'),
            'active_title' => __('List'),
            'button_type'  => 'create',
            'button_title' => __('siteVisit Create'),
            'button_url'   => route('siteVisit.create'),
        ];
        $siteVisits   = (new SiteVisit())->get_siteVisit($request);
        $search      = $request->all();
        $columns     = [
            'name'       => 'Name',
            'sort_order' => 'Sort Order',
            'status'     => 'Status',
            ];
        return view('admin.modules.siteVisit.index',
        compact('cms_content', 'siteVisits', 'search', 'columns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create():View
    {
        $cms_content = [
            'module'       => __('siteVisit'),
            'module_url'   => route('siteVisit.index'),
            'active_title' => __('Create'),
            'button_type'  => 'list',
            'button_title' => __('siteVisit List'),
            'button_url'   => route('siteVisit.index'),
        ];
        return view('admin.modules.siteVisit.create', compact('cms_content'));
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreSiteVisitRequest $request):RedirectResponse
    {
        try {
           DB::beginTransaction();
           $siteVisit = (new SiteVisit())->store_siteVisit($request);
           $original  = $siteVisit->getOriginal();
           $changed   = $siteVisit->getChanges();
           self::activityLog($request, $original, $changed, $siteVisit);
           success_alert(__('siteVisit created successfully'));
           DB::commit();
           return redirect()->route('siteVisit.index');
       } catch (Throwable $throwable) {
           DB::rollBack();
           app_error_log('siteVisit_CREATE_FAILED', $throwable, 'error');
           failed_alert($throwable->getMessage());
           return redirect()->back();
       }
    }

    /**
     * Display the specified resource.
     */
    final public function show(SiteVisit $siteVisit):View
    {
        $cms_content = [
            'module'       => __('siteVisit'),
            'module_url'   => route('siteVisit.index'),
            'active_title' => __('Details'),
            'button_type'  => 'list',
            'button_title' => __('siteVisit List'),
            'button_url'   => route('siteVisit.index'),
        ];
        $siteVisit->load(['activity_logs', 'created_by', 'updated_by']);

        return view('admin.modules.siteVisit.show',
                   compact('siteVisit', 'cms_content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(SiteVisit $siteVisit):View
    {
        $cms_content = [
            'module' => __('siteVisit'),
            'module_url'  => route('siteVisit.index'),
            'active_title' => __('Edit'),
            'button_type'  => 'list',
            'button_title'  => __('siteVisit List'),
            'button_url' => route('siteVisit.index'),
        ];
        return view('admin.modules.siteVisit.edit', compact(
                    'cms_content',
                    'siteVisit',
                ));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateSiteVisitRequest $request, SiteVisit $siteVisit):RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $siteVisit->getOriginal();
            (new SiteVisit())->update_siteVisit($request, $siteVisit);
            $changed = $siteVisit->getChanges();
            self::activityLog($request, $original, $changed, $siteVisit);
            DB::commit();
            success_alert(__('siteVisit updated successfully'));
            return redirect()->route('siteVisit.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('siteVisit_UPDATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Request $request, SiteVisit $siteVisit):RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $siteVisit->getOriginal();
            (new SiteVisit())->delete_siteVisit($siteVisit);
            $changed = $siteVisit->getChanges();
            self::activityLog($request, $original, $changed, $siteVisit);
            DB::commit();
            success_alert(__('siteVisit deleted successfully'));
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('siteVisit_DELETE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            }
        return redirect()->back();
    }
}
