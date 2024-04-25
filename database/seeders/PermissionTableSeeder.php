<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Overides\Permission;
use App\Models\Overides\Role;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::get()->each->delete();
        $defaults           = Permission::getDefaultPermissons();
        $adminPermissions   = Permission::getAdminPermissions();
        $guards = ['admin'];

        foreach ($defaults as $group => $permissions) {
            foreach ($permissions as $permission) {
                foreach ($guards as $guard) {
                    Permission::create([
                        'name'          =>  $permission,
                        'guard_name'    =>  $guard,
                        'properties'    =>  [
                        'group' =>  $group
                        ]
                    ]);
                }
            }
        }

        /**
         * Admin Permission Seeder
         */

         foreach ($adminPermissions as $group => $permissions) {
            foreach ($permissions as $permission) {
                $createdPermission = Permission::create([
                    'name' => $permission,
                    'guard_name' => 'admin',
                    'properties' => [
                        'group' => $group,
                    ],
                ]);
            }
        }
    }
}
