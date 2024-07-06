<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    final public function home()
    {
        return view('site.home.index');
    }
}
