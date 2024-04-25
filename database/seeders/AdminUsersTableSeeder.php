<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->truncate();
         $admin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password')
        ]);

        $role = Role::create([
            'name' => 'SuperAdmin',
            'guard_name' => 'admin',
            'roleable_id' => $admin->id,
            'roleable_type' => $admin->getMorphClass(),
        ]);
        $admin->syncRoles('SuperAdmin'); 
    }
}