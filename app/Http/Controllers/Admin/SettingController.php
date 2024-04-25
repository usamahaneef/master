<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.setting.index',[
            'title' => 'Settings',
            'menu_active' => 'setting',
            'tab_active' => 'active',
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'avatar' => 'nullable',
        ]);

        $admin = Auth('admin')->user();
        $admin->name = $request->first_name . ' ' . $request->last_name;
        $image = $request->avatar;
        if ($image) {
            $admin->addMedia($image)->toMediaCollection('avatar');
        }
        $admin->save();
        return redirect()->route('admin.dashboard')->with('success' , 'Profile Picture updated');
    }
}
