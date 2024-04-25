<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    
    public function showResetForm()
    {
        // dd("reset");

        return view('auth.admin.reset-password',[
            'title' => 'Reset Password',
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $admin = Admin::where('email' , $request->email)->first();
        $admin->password = Hash::make($request->password);
        $admin->remember_token = null;
        $admin->save();

        Auth::guard('admin')->login($admin);
        return redirect()->route('admin.dashboard')->with('success', 'Your password has been changed!');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

}
