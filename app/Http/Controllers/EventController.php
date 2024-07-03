<?php

namespace App\Http\Controllers;

use App\Manager\AccessControl\AccessControlTrait;
use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Manager\API\Traits\CommonResponse;
use App\Models\EventCategory;
use App\Models\Traits\AppActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class EventController extends Controller
{
    use CommonResponse, AppActivityLog, AccessControlTrait;

    public static string $route = 'event';

    /**
     * Display a listing of the resource.
     */
    final public function index(Request $request): View
    {
        $cms_content = [
            'module'       => __('event'),
            'module_url'   => route('event.index'),
            'active_title' => __('List'),
            'button_type'  => 'create',
            'button_title' => __('event Create'),
            'button_url'   => route('event.create'),
        ];

        $status  = Event::STATUS_LIST;
        $events  = (new Event())->get_events($request);
        $search  = $request->all();
        $columns = [
            'name'       => 'Name',
            'sort_order' => 'Sort Order',
            'status'     => 'Status',
        ];
        return view(
            'admin.modules.event.index',
            compact('cms_content', 'events', 'search', 'columns', 'status')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create(): View
    {
        $cms_content = [
            'module'       => __('event'),
            'module_url'   => route('event.index'),
            'active_title' => __('Create'),
            'button_type'  => 'list',
            'button_title' => __('event List'),
            'button_url'   => route('event.index'),
        ];
        $status = Event::STATUS_LIST;
        $categories = (new EventCategory())->get_categories_assoc();

        return view('admin.modules.event.create', compact('cms_content', 'categories', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreEventRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $event = (new Event())->store_event($request);
            $original = $event->getOriginal();
            $changed = $event->getChanges();
            self::activityLog($request, $original, $changed, $event);
            success_alert(__('event created successfully'));
            DB::commit();
            return redirect()->route('event.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('event_CREATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    final public function show(Event $event): View
    {
        $cms_content = [
            'module' => __('event'),
            'module_url'  => route('event.index'),
            'active_title' => __('Details'),
            'button_type'  => 'list',
            'button_title'  => __('event List'),
            'button_url' => route('event.index'),
        ];
        $event->load(['activity_logs', 'created_by', 'updated_by']);
        $seo = $event->seo;
        return view(
            'admin.modules.event.show',
            compact('event', 'cms_content', 'seo')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(Event $event): View
    {
        $cms_content = [
            'module' => __('event'),
            'module_url'  => route('event.index'),
            'active_title' => __('Edit'),
            'button_type'  => 'list',
            'button_title'  => __('event List'),
            'button_url' => route('event.index'),
        ];

        $status = Event::STATUS_LIST;
        $categories = (new EventCategory())->get_categories_assoc();
        $seo  = $event->seo;      
        return view('admin.modules.event.edit', compact(
            'cms_content',
            'event',
            'status',
            'seo',
            'categories'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $event->getOriginal();
            (new Event())->update_event($request, $event);
            $changed = $event->getChanges();
            self::activityLog($request, $original, $changed, $event);
            DB::commit();
            success_alert(__('event updated successfully'));
            return redirect()->route('event.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('event_UPDATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Request $request, Event $event): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $event->getOriginal();
            (new Event())->delete_event($event);
            $changed = $event->getChanges();
            self::activityLog($request, $original, $changed, $event);
            DB::commit();
            success_alert(__('event deleted successfully'));
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('event_DELETE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
        }
        return redirect()->back();
    }
}
