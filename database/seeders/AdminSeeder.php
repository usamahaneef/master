<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Gender;
use App\Models\Hospital;
use App\Models\Hospital\BloodGroup;
use App\Models\Hospital\Doctor;
use App\Models\Hospital\DoctorSpeciality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->truncate();
        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);        
    }
}
