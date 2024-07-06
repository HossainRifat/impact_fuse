<?php

namespace App\Http\Controllers;

use App\Manager\AccessControl\AccessControlTrait;
use App\Models\Inquiry;
use App\Http\Requests\StoreInquiryRequest;
use App\Http\Requests\UpdateInquiryRequest;
use App\Manager\API\Traits\CommonResponse;
use App\Models\Traits\AppActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class InquiryController extends Controller
{
    use CommonResponse, AppActivityLog, AccessControlTrait;

    public static string $route = 'inquiry';

    /**
     * Display a listing of the resource.
     */
    final public function index(Request $request): View
    {
        $cms_content = [
            'module'       => __('inquiry'),
            'module_url'   => route('inquiry.index'),
            'active_title' => __('List'),
            'button_type'  => 'create',
            'button_title' => __('inquiry Create'),
            'button_url'   => route('inquiry.create'),
        ];
        $inquiries = (new Inquiry())->get_inquiries($request);
        $status   = Inquiry::STATUS_LIST;
        $search   = $request->all();
        $columns  = [
            'status'     => 'Status',
        ];
        return view(
            'admin.modules.inquiry.index',
            compact('cms_content', 'inquiries', 'search', 'columns', 'status')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create(): View
    {
        $cms_content = [
            'module'       => __('inquiry'),
            'module_url'   => route('inquiry.index'),
            'active_title' => __('Create'),
            'button_type'  => 'list',
            'button_title' => __('inquiry List'),
            'button_url'   => route('inquiry.index'),
        ];
        $status = Inquiry::STATUS_LIST;
        return view('admin.modules.inquiry.create', compact('cms_content', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreInquiryRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $inquiry  = (new Inquiry())->store_inquiry($request);
            $original = $inquiry->getOriginal();
            $changed  = $inquiry->getChanges();
            self::activityLog($request, $original, $changed, $inquiry);
            success_alert(__('inquiry created successfully'));
            DB::commit();
            return redirect()->route('inquiry.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('inquiry_CREATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    final public function show(Inquiry $inquiry): View
    {
        $cms_content = [
            'module' => __('inquiry'),
            'module_url'  => route('inquiry.index'),
            'active_title' => __('Details'),
            'button_type'  => 'list',
            'button_title'  => __('inquiry List'),
            'button_url' => route('inquiry.index'),
        ];
        $inquiry->load(['activity_logs', 'created_by', 'updated_by']);
        $status = Inquiry::STATUS_LIST;
        return view(
            'admin.modules.inquiry.show',
            compact('inquiry', 'cms_content', 'status')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(Inquiry $inquiry): View
    {
        $cms_content = [
            'module' => __('inquiry'),
            'module_url'  => route('inquiry.index'),
            'active_title' => __('Edit'),
            'button_type'  => 'list',
            'button_title'  => __('inquiry List'),
            'button_url' => route('inquiry.index'),
        ];
        $status = Inquiry::STATUS_LIST;
        return view('admin.modules.inquiry.edit', compact(
            'cms_content',
            'inquiry',
            'status'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateInquiryRequest $request, Inquiry $inquiry): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $inquiry->getOriginal();
            (new Inquiry())->update_inquiry($request, $inquiry);
            $changed = $inquiry->getChanges();
            self::activityLog($request, $original, $changed, $inquiry);
            DB::commit();
            success_alert(__('inquiry updated successfully'));
            return redirect()->route('inquiry.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('inquiry_UPDATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Request $request, Inquiry $inquiry): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $inquiry->getOriginal();
            (new Inquiry())->delete_inquiry($inquiry);
            $changed = $inquiry->getChanges();
            self::activityLog($request, $original, $changed, $inquiry);
            DB::commit();
            success_alert(__('inquiry deleted successfully'));
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('inquiry_DELETE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
        }
        return redirect()->back();
    }
}
