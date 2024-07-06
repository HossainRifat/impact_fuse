<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminProfileUpdateRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\RoleExtended;
use App\Models\Traits\AppActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;

use Throwable;

class UserController extends Controller
{
    use AppActivityLog;

    final public function index(Request $request): View
    {
        $cms_content = [
            'module'       => __('User'),
            'module_url'   => route('user.index'),
            'active_title' => __('List'),
            'button_type'  => 'create',
            'button_title' => __('Create User'),
            'button_url'   => route('user.create'),
        ];
        $status  = User::STATUS_LIST;
        $users   = (new User())->get_admins($request);
        $roles   = (new RoleExtended())->get_roles_assoc();
        $search  = $request->all();
        $columns = [
            'id'            => 'ID',
            'name'          => 'Name',
            'email'         => 'Email',
            'phone'         => 'Phone',
            'status'        => 'Status',
            'last_activity' => 'Last Activity',
            'created_at'    => 'Created Time',
            'updated_at'    => 'Updated Time'
        ];
        $search = $request->all();

        return view('admin.modules.user.index', compact('cms_content', 'users', 'search', 'columns', 'roles', 'status'));
    }


    /**
     * @return View
     */
    final public function create(Request $request): View
    {
        $cms_content = [
            'module'       => __('User'),
            'module_url'   => route('user.index'),
            'active_title' => __('Create'),
            'button_type'  => 'list',
            'button_title' => __('User List'),
            'button_url'   => route('user.index'),
        ];
        $roles      = (new RoleExtended())->get_roles_assoc();
        $status     = User::STATUS_LIST;

        return view('admin.modules.user.create', compact('cms_content', 'roles', 'status'));
    }

    /**
     * @return View
     */
    final public function profile_create(): View
    {
        $cms_content = [
            'module'       => __('Profile'),
            'module_url'   => route('profile.create'),
            'active_title' => __('Update'),
            'button_type'  => 'list',
            'button_title' => __('Dashboard'),
            'button_url'   => route('dashboard'),
        ];
        $user        = Auth::user();

        return view(
            'admin.modules.admin-profile.create',
            compact('cms_content', 'user')
        );
    }

    /**
     * @param AdminProfileUpdateRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    final public function store(AdminProfileUpdateRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $user = (new User())->store_user($request);
            $original = $user->getOriginal();
            $changed  = $user->getChanges();
            self::activityLog($request, $original, $changed, $user);
            DB::commit();
            success_alert('User created successfully');
            return redirect()->route('user.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            dd($throwable->getMessage());
            app_error_log('USER_CREATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }


    final public function edit(User $user, Request $request): View
    {
        $cms_content = [
            'module'       => __('User'),
            'module_url'   => route('user.index'),
            'active_title' => __('Edit'),
            'button_type'  => 'list',
            'button_title' => __('User List'),
            'button_url'   => route('user.index'),
        ];
        $roles           = (new RoleExtended())->get_roles_assoc();
        $status          = User::STATUS_LIST;

        return view('admin.modules.user.edit', compact('cms_content', 'user', 'roles', 'status'));
    }

    final public function show(User $user, Request $request): View
    {
        $user->load(['roles', 'profile_photo']);
        $cms_content = [
            'module'       => __('User'),
            'module_url'   => route('user.index'),
            'active_title' => __('Show'),
            'button_type'  => 'list',
            'button_title' => __('User List'),
            'button_url'   => route('user.index'),
        ];
        $search = $request->all();

        return view('admin.modules.user.show', compact('cms_content', 'user'));
    }


    final public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $original = $user->getOriginal();
            (new User())->update_user($request, $user);
            $changed = $user->getChanges();
            // self::activityLog($request, $original, $changed, $user);
            DB::commit();
            success_alert('User updated successfully');

            return redirect()->route('user.index');
        } catch (Throwable $throwable) {
            DB::rollBack();
            dd($throwable->getMessage());
            app_error_log('USER_UPDATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    final public function destroy(Request $request, User $user): RedirectResponse
    {
        try {
            DB::beginTransaction();
            (new User())->delete_user($user);
            DB::commit();
            success_alert('User deleted successfully');
            return redirect()->back();
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('USER_DELETE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }

    /**
     * @param AdminProfileUpdateRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    final public function profile_store(AdminProfileUpdateRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            (new User())->update_own_profile($request);
            DB::commit();
            success_alert('Profile updated successfully');
            return redirect()->back();
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('PROFILE_UPDATE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
            return redirect()->back();
        }
    }
}
