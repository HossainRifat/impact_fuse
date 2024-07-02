<?php

namespace App\Http\Controllers;

use App\Manager\AccessControl\AccessControlTrait;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Manager\API\Traits\CommonResponse;
use App\Models\Traits\AppActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class ProjectController extends Controller
{
    use CommonResponse, AppActivityLog, AccessControlTrait;

    public static string $route = 'project';

    /**
     * Display a listing of the resource.
     */
    final public function index(Request $request):View
    {
        $cms_content = [
            'module'        => __('project'),
            'module_url'  => route('project.index'),
            'active_title' => __('List'),
            'button_type'  => 'create',
            'button_title'  => __('project Create'),
            'button_url' => route('project.create'),
        ];
        $projects   = (new Project())->get_project($request);
        $search      = $request->all();
        $columns     = [
            'name'       => 'Name',
            'sort_order' => 'Sort Order',
            'status'     => 'Status',
            ];
        return view('admin.modules.project.index',
        compact('cms_content', 'projects', 'search', 'columns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create():View
    {
        $cms_content = [
            'module' => __('project'),
            'module_url'  => route('project.index'),
            'active_title' => __('Create'),
            'button_type'  => 'list',
            'button_title'  => __('project List'),
            'button_url' => route('project.index'),
        ];
        return view('admin.modules.project.create', compact('cms_content'));
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreProjectRequest $request):RedirectResponse
    {
        try {
           DB::beginTransaction();
           $project = (new Project())->store_project($request);
           $original = $project->getOriginal();
           $changed = $project->getChanges();
           self::activityLog($request, $original, $changed, $project);
           success_alert(__('project created successfully'));
           DB::commit();
           return redirect()->route('project.index');
       } catch (Throwable $throwable) {
           DB::rollBack();
           app_error_log('project_CREATE_FAILED', $throwable, 'error');
           failed_alert($throwable->getMessage());
           return redirect()->back();
       }
    }

    /**
     * Display the specified resource.
     */
    final public function show(Project $project):View
    {
        $cms_content = [
            'module' => __('project'),
            'module_url'  => route('project.index'),
            'active_title' => __('Details'),
            'button_type'  => 'list',
            'button_title'  => __('project List'),
            'button_url' => route('project.index'),
        ];
        $project->load(['activity_logs', 'created_by', 'updated_by']);

        return view('admin.modules.project.show',
                   compact('project', 'cms_content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(Project $project):View
    {
        $cms_content = [
            'module' => __('project'),
            'module_url'  => route('project.index'),
            'active_title' => __('Edit'),
            'button_type'  => 'list',
            'button_title'  => __('project List'),
            'button_url' => route('project.index'),
        ];
        return view('admin.modules.project.edit', compact(
                    'cms_content',
                    'project',
                ));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateProjectRequest $request, Project $project):RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $project->getOriginal();
            (new Project())->update_project($request, $project);
            $changed = $project->getChanges();
            self::activityLog($request, $original, $changed, $project);
            DB::commit();
            success_alert(__('project updated successfully'));
            return redirect()->route('project.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('project_UPDATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Request $request, Project $project):RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $project->getOriginal();
            (new Project())->delete_project($project);
            $changed = $project->getChanges();
            self::activityLog($request, $original, $changed, $project);
            DB::commit();
            success_alert(__('project deleted successfully'));
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('project_DELETE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            }
        return redirect()->back();
    }
}
