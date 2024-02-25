<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.sections.dashboard',[
            'title' => 'Dashboard',
            'nav_menu' => 'dashboard',
            'nav_sub_menu' => '',
        ]);
    }
}
