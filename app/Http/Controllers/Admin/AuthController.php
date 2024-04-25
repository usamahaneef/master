<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\adminResetPassword;
use App\Models\Admin;
use Mail;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function showLoginForm()
    {
        return view('auth.admin.login',[
            'title' => 'Login',
        ]);
    }

    public function forgotPassword()
    {
        return view('auth.admin.forgot-password' ,[
            'title' => 'Forgot Password',
        ]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins',
        ]);
        
        $token = Str::random(64);
        $admin = Admin::whereEmail($request->email)->first();
        $admin->update([
            'remember_token' => $token, 
            'created_at' => Carbon::now()
          ]);

        $details = [
            'title' => 'Reset Your Password',
            'name' => $admin->name,
            'token' => $token,
            'email' => $request->email,
            'password_reset_url' => 'admin/reset-password/{token}' . $token
        ];
        Mail::to($request->email)->send(new adminResetPassword($details));
        return redirect()->back()->with('success', 'Check Email For Reset Password');
    }

    public function broker()
    {
        return Password::broker('admin');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function redirectTo()
    {
        return route('admin.dashboard');
    }
    public function updatePassword()
    {
        return view('admin.update-password',[
            'title' => 'Update Password',
            'menu_active' => 'password',
            'tab_active' => 'active',
        ]);
    }
        
    public function storePassword(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'current_password' => [
                'required',
                Rule::requiredIf(function () use ($user, $request) {
                    return Hash::check($request->current_password, $user->password);
                }),
            ],
            'change_password' => 'required|min:8',
            'confirm_password' => 'required|same:change_password'
        ], [
            'current_password.required' => 'The current password is incorrect.',
        ]);
    
        if ($request->current_password && Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->change_password);
            $user->save();
            Auth::logout();
            return redirect(route('admin.login'));
        } else {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
    }

    public function loggedOut(Request $request)
    {
        return redirect(route('admin.login'));
    }
}
