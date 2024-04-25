<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\CustomPermission;
use App\Models\Society;
use App\Models\Venue;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function userPermissions(Admin $user)
    {
        $venuesPermissions = CustomPermission::where('user_id', $user->id)
            ->where('model_type', 'App\Models\Venue')
            ->first();

        $societyPermissions = CustomPermission::where('user_id', $user->id)
            ->where('model_type', 'App\Models\Society')
            ->first();
        
        return view('admin.sections.general.permissions.create', [
            'title' => 'users',
            'menu_active' => 'admin_users',
            'societies' => Society::all(),
            'venues' => Venue::all(),
            'venuesPermissions' => $venuesPermissions,
            'societyPermissions' => $societyPermissions,
            'user' => $user,
        ]);
    }

    public function societiesPermissions(Request $request , Admin $user)
    {
        $request->validate([
            'societies_id' => 'required|array'
        ]);

        $customPermission = CustomPermission::where('user_id', $user->id)
            ->where('model_type', 'App\Models\Society')
            ->first();
        
        if ($customPermission) {
            $customPermission->permission_id = $request->societies_id;
            $customPermission->save();
            return redirect()->back()->with('success', 'Society permissions updated successfully');
        } else {
            $customPermission = new CustomPermission();
            $customPermission->user_id = $user->id;
            $customPermission->model_type = 'App\Models\Society';
            $customPermission->permission_id = $request->societies_id;
            $customPermission->save();
            return redirect()->back()->with('success', 'Society permissions Added successfully');
        }
    }

    public function venuesPermissions(Request $request , Admin $user)
    {
       $request->validate([
        'venues_id' => 'required|array'
       ]);   

        $customPermission = CustomPermission::where('user_id', $user->id)
            ->where('model_type', 'App\Models\Venue')
            ->first();

        if ($customPermission) {
            $customPermission->permission_id = $request->venues_id;
            $customPermission->save();
            return redirect()->back()->with('success', 'Venue permissions updated successfully');
        } else {

            $customPermission = new CustomPermission();
            $customPermission->user_id = $user->id;
            $customPermission->model_type = 'App\Models\Venue';
            $customPermission->permission_id = $request->venues_id;
            $customPermission->save();
            return redirect()->back()->with('success', 'Venue permissions added successfully');
        }
    }
    
}
