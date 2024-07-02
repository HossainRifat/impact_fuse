<?php

namespace App\Http\Controllers;

use App\Manager\AccessControl\AccessControlTrait;
use App\Models\Service;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Manager\API\Traits\CommonResponse;
use App\Models\Traits\AppActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class ServiceController extends Controller
{
    use CommonResponse, AppActivityLog, AccessControlTrait;

    public static string $route = 'service';

    /**
     * Display a listing of the resource.
     */
    final public function index(Request $request): View
    {
        $cms_content = [
            'module'       => __('Service'),
            'module_url'   => route('service.index'),
            'active_title' => __('List'),
            'button_type'  => 'create',
            'button_title' => __('Service Create'),
            'button_url'   => route('service.create'),
        ];
        $services = (new Service())->get_service($request);
        $search   = $request->all();
        $status   = Service::STATUS_LIST;
        $columns  = [
            'created_at' => 'Created At',
            'name'       => 'Name',
            'sort_order' => 'Sort Order',
            'status'     => 'Status',
        ];
        return view(
            'admin.modules.service.index',
            compact('cms_content', 'services', 'search', 'columns', 'status')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create(): View
    {
        $cms_content = [
            'module'       => __('service'),
            'module_url'   => route('service.index'),
            'active_title' => __('Create'),
            'button_type'  => 'list',
            'button_title' => __('service List'),
            'button_url'   => route('service.index'),
        ];
        $status   = Service::STATUS_LIST;
        $services = (new Service())->get_assoc();

        return view('admin.modules.service.create', compact('cms_content', 'status', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreServiceRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $service  = (new Service())->store_service($request);
            $original = $service->getOriginal();
            $changed  = $service->getChanges();
            self::activityLog($request, $original, $changed, $service);
            success_alert(__('service created successfully'));
            DB::commit();
            return redirect()->route('service.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            dd($throwable->getMessage());
            app_error_log('service_CREATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    final public function show(Service $service): View
    {
        $cms_content = [
            'module'       => __('service'),
            'module_url'   => route('service.index'),
            'active_title' => __('Details'),
            'button_type'  => 'list',
            'button_title' => __('service List'),
            'button_url'   => route('service.index'),
        ];
        $service->load(['activity_logs', 'created_by', 'updated_by', 'seo', 'photo']);
        $seo = $service->seo;

        return view(
            'admin.modules.service.show',
            compact('service', 'cms_content', 'seo')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(Service $service): View
    {
        $cms_content = [
            'module'       => __('service'),
            'module_url'   => route('service.index'),
            'active_title' => __('Edit'),
            'button_type'  => 'list',
            'button_title' => __('service List'),
            'button_url'   => route('service.index'),
        ];

        $status = Service::STATUS_LIST;
        $services = (new Service())->get_assoc();
        $seo  = $service->seo;
        return view('admin.modules.service.edit', compact(
            'cms_content',
            'service',
            'status',
            'services',
            'seo'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $service->getOriginal();
            (new Service())->update_service($request, $service);
            $changed = $service->getChanges();
            self::activityLog($request, $original, $changed, $service);
            DB::commit();
            success_alert(__('service updated successfully'));
            return redirect()->route('service.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('service_UPDATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Request $request, Service $service): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $service->getOriginal();
            (new Service())->delete_service($service);
            $changed = $service->getChanges();
            self::activityLog($request, $original, $changed, $service);
            DB::commit();
            success_alert(__('service deleted successfully'));
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('service_DELETE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
        }
        return redirect()->back();
    }
}
