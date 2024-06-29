<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * @return View
     */
    final public function index(): View
    {
        $cms_content = [
            'module'       => __('Report'), // page title and breadcrumb's first element title
            'module_url'   => route('dashboard'),
            'active_title' => __('Sales Report'), // breadcrumb's active title
            'button_type'  => 'delete', // list|create|edit, page right button
            'button_title' => __('Report'),
            'button_url'   => route('dashboard'),
        ];
        return view('admin.modules.dashboard.index', compact('cms_content'));
    }

    final public function switchTheme(Request $request): RedirectResponse
    {
        set_theme($request->input('theme_id', 1));
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    final public function switchLanguage(Request $request): RedirectResponse
    {
        $language = $request->input('locale', 'en');
        app()->setLocale($language);
        Cache::put('language', $language);
        return redirect()->back();
    }
}
