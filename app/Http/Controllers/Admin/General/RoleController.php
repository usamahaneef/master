<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use App\Models\Overides\Permission;
use App\Models\Overides\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
// use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    
    public function index()
    {
        $roles = Role::where('guard_name' , 'admin')
            ->withoutSuperAdmin()
            ->withCount(['users', 'permissions'])
            ->get();
        return view('admin.sections.general.roles.index' , [
            'title' => 'Role',
            'menu_active' => 'roles',
            'nav_sub_menu' => '',
            'roles' => $roles
        ]);
    }

    public function AddNewRole(Role $role, Request $request)
    {
        $validate =Validator::make($request->all(), [
                "add_role_name"  =>  [
                    "required",
                    "min:3",
                    "max:50",
                    Rule::unique($role->getTable(), 'name')
                        ->where('guard_name', 'admin')
                ]
        ], [], ['add_role_name' => 'Role Name']);

        if ($validate->fails()) {
            Session::flash('modal', 'add-new-role', true);
            return redirect()->back()->withErrors($validate->errors());
        }

        $role->name = $request->add_role_name;
        $role->guard_name = 'admin';
        
        $role->save();

        return redirect()->route('admin.roles')->with('success', 'New Role Added');
    }

    public function updateRole(Request $request)
    {
        $role = Role::whereId($request->edit_role_id)->first();
        $validate = Validator::make($request->all(), [
            'edit_role_id' => ['required'],
            'edit_role_name' => [
                "required",
                "min:3",
                "max:50",
                Rule::unique('roles', 'name')
                    ->where('guard_name', 'admin')
                    
            ],
        ], [], ['edit_role_name' => 'Role Name']);
        if ($validate->fails()) {
            Session::flash('modal', 'edit-role', true);
            return redirect()->back()->withErrors($validate->errors());
        }
        $role->name = $request->edit_role_name;
        $role->save();

        return redirect()->route('admin.roles')->with('success', 'Role updated successfully');
    }

    public function deleteRole(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'delete_role_id' => ['required']
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->errors());
        }
        Role::whereId($request->delete_role_id)->delete();
        return redirect()->route('admin.roles')->with('success', 'Role deleted successfully');
    }

    public function rolePermissions(Role $role, Request $request)
    {
        $permissions = Permission::whereGuardName('admin')->get()->groupBy('properties.group');
        $rolePermissions = $role->permissions()->get();
        $rolePermissions = empty($rolePermissions) ? [] : $rolePermissions->pluck('id')->toArray();
        return view('admin.sections.general.roles.permissions', [
            'title' => 'Roles',
            'menu_active' => 'roles',
            'nav_sub_menu' => '',
            'role' => $role,
            'rolePermissions' => $rolePermissions,
            'permissions' => $permissions,
        ]);
    }

    public function updateRolePermissions(Role $role, Request $request)
    {
        $request->validate([
            'permissions' => ['required', 'array']
        ]);
        $role->syncPermissions($request->permissions );
        return redirect()->route('admin.role.permissions.index', $role)->with('success', "Permissions for role {$role->name} Updated");
    }
}
