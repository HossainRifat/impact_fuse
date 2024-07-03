<?php

namespace App\Http\Controllers;

use App\Manager\AccessControl\AccessControlTrait;
use App\Models\EventCategory;
use App\Http\Requests\StoreEventCategoryRequest;
use App\Http\Requests\UpdateEventCategoryRequest;
use App\Manager\API\Traits\CommonResponse;
use App\Models\Traits\AppActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class EventCategoryController extends Controller
{
    use CommonResponse, AppActivityLog, AccessControlTrait;

    public static string $route = 'event-category';

    /**
     * Display a listing of the resource.
     */
    final public function index(Request $request): View
    {
        $cms_content = [
            'module'       => __('Event Category'),
            'module_url'   => route('event-category.index'),
            'active_title' => __('List'),
            'button_type'  => 'create',
            'button_title' => __('Event Category Create'),
            'button_url'   => route('event-category.create'),
        ];
        $categories = (new EventCategory())->get_categories($request);
        $status     = EventCategory::STATUS_LIST;
        $search     = $request->all();
        $columns    = [
            'name'       => 'Name',
            'sort_order' => 'Sort Order',
            'status'     => 'Status',
        ];
        return view(
            'admin.modules.event-category.index',
            compact('cms_content', 'categories', 'search', 'columns', 'status')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create(): View
    {
        $cms_content = [
            'module'       => __('Event Category'),
            'module_url'   => route('event-category.index'),
            'active_title' => __('Create'),
            'button_type'  => 'list',
            'button_title' => __('Event Category List'),
            'button_url'   => route('event-category.index'),
        ];
        $categories = (new EventCategory())->get_categories_assoc();
        $status     = EventCategory::STATUS_LIST;

        return view('admin.modules.event-category.create', compact('cms_content', 'categories', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreEventCategoryRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $event_category = (new EventCategory())->store_category($request);
            $original = $event_category->getOriginal();
            $changed = $event_category->getChanges();
            self::activityLog($request, $original, $changed, $event_category);
            success_alert(__('Event Category created successfully'));
            DB::commit();
            return redirect()->route('event-category.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('Event_Category_CREATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    final public function show(EventCategory $event_category): View
    {
        $cms_content = [
            'module' => __('Event Category'),
            'module_url'  => route('event-category.index'),
            'active_title' => __('Details'),
            'button_type'  => 'list',
            'button_title'  => __('Event Category List'),
            'button_url' => route('event-category.index'),
        ];

        $event_category->load(['activity_logs', 'created_by', 'updated_by', 'seo', 'photo', 'activity_logs.created_by', 'activity_logs.updated_by']);
        $seo = $event_category->seo;

        return view(
            'admin.modules.event-category.show',
            compact('event_category', 'cms_content', 'seo')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(EventCategory $event_category): View
    {
        $cms_content = [
            'module'       => __('Event Category'),
            'module_url'   => route('event-category.index'),
            'active_title' => __('Edit'),
            'button_type'  => 'list',
            'button_title' => __('Event Category List'),
            'button_url'   => route('event-category.index'),
        ];

        $event_category->load(['seo', 'photo']);
        $status     = EventCategory::STATUS_LIST;
        $categories = (new EventCategory())->get_categories_assoc();
        $seo        = $event_category->seo;

        return view('admin.modules.event-category.edit', compact(
            'cms_content',
            'event_category',
            'status',
            'categories',
            'seo'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateEventCategoryRequest $request, EventCategory $event_category): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $event_category->getOriginal();
            (new EventCategory())->update_category($request, $event_category);
            $changed = $event_category->getChanges();
            self::activityLog($request, $original, $changed, $event_category);
            DB::commit();
            success_alert(__('Event category updated successfully'));
            return redirect()->route('event-category.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('Event_Category_UPDATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Request $request, EventCategory $event_category): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $event_category->getOriginal();
            (new EventCategory())->delete_category($event_category);
            $changed = $event_category->getChanges();
            self::activityLog($request, $original, $changed, $event_category);
            DB::commit();
            success_alert(__('Event category deleted successfully'));
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('Event_Category_DELETE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
        }
        return redirect()->back();
    }
}
