<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function showLoginForm()
    {
        return view('auth.admin.login',[
            'title' => 'Login',
        ]);
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function redirectTo()
    {
        return route('admin.dashboard');
    }

    public function loggedOut(Request $request)
    {
        return redirect(route('admin.login'));
    }
}
