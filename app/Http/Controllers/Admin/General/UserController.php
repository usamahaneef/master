<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use App\Mail\adminUserInvitation;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = Admin::with(['roles'])->get();
        return view('admin.sections.general.users.index', [
            'title' => 'users',
            'menu_active' => 'admin_users',
            'nav_sub_menu' => '',
            'users' => $users,
            'roles' => Role::where('name', '!=', 'SuperAdmin')->get(),
        ]);
    }

    public function addNewUser(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "add_first_name"   =>  ['required', 'max:50',"regex:/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u"],
            "add_email"        =>  ['required', 'unique:admins,email'],
            "role"              =>  ["required", "exists:roles,id"],
            "avatar"
        ], [
            "add_first_name.regex" => "Name should not contain numbers",
            "email.unique" => "The added email is already in use"
        ], [
            "add_first_name" => "First Name",
            "add_last_name" => "Last Name",
        ]);
        if ($validate->fails()) {
            Session::flash('add_user_modal', true);
            return redirect()->back()->withErrors($validate->errors())->withInput();
        }else {
            Session::flash('add_user_modal', false);
        }

        $admin = new Admin();
        $admin->name = $request->add_first_name;
        $admin->email = $request->add_email;
        $admin->password = Hash::make('password');
        $admin->save();
        $admin->syncRoles($request->role);  
        if ($request->avatar) {
            $admin->addMedia($request->avatar->path())->usingFileName(Str::random(34))->toMediaCollection('profile_picture');
        }

        $token = Str::random(64);
        $admin->update([
            'remember_token' => $token, 
            'created_at' => Carbon::now()
          ]);

        $details = [
            'title' => 'Welcome to AURA platform',
            'name' => $admin->name,
            'token' => $token,
            'email' => $admin->email,
            'password_reset_url' => 'admin/reset-password/{token}' . $token
        ];
        // Mail::to($admin->email)->send(new adminUserInvitation($details));
        return redirect()->route('admin.user.index')->with('success', 'User Added successfully');
    }

    public function editUser(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => ['required','exists:admins,id']
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => 102,
                'message' => 'User does not exist',
                'validation_errors' => $validate->errors(),
                'data' => null,
            ]);
        }

        $user = Admin::whereId($request->user_id)->first();
        if (!$user) {
            return response()->json([
                'status' => 100,
                'message' => 'User does not exist',
                'validation_errors' => $validate->errors(),
                'data' => null,
            ]);
        }
        return response()->json([
            'status' => 101,
            'message' => 'SUCCESS',
            'validation_errors' => $validate->errors(),
            'data' => [
                'user' => $user,
                'userRole' => $user->roles->first(),
            ],
        ]);
    }

    public function updateUser(Request $request)
    {
        $user = Admin::find($request->edit_user_id);
        // $user->runAttributeChecks();
        $validate = Validator::make($request->all(), [
            "edit_first_name"   =>  ['required', 'max:50',"regex:/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u"],
            "edit_email"        =>  ['required', 'email', Rule::unique('admins', 'email')->ignore($request->edit_user_id, 'id')],
            "edit_role"         =>  [Rule::requiredIf(function () use ($user) {
                                        return $user->roles?->first()?->name != "SuperAdmin";
            }), "exists:roles,id"],
            "avatar"
        ], [
            "edit_first_name.regex" => "Name should not contain numbers",
            "add_email.unique" => "The added email is already in use"
        ], [
            "edit_first_name" => "First Name",
        ]);

        if ($validate->fails()) {
            Session::flash('edit_user_modal', true);
            return redirect()->back()->withInput()->withErrors($validate->errors())->withInput();
        } else {
            Session::flash('edit_user_modal', false);
        }
        $user->name = $request->edit_first_name;
        $user->email = $request->edit_email;
        $user->save();
        $user->syncRoles($request->edit_role);

        if ($request->avatar) {
            $user->addMedia($request->avatar->path())
            ->usingFileName(Str::random(50))
            ->toMediaCollection('profile_picture');
        }

        return redirect()->route('admin.user.index')->with('success', 'User updated successfully');
    }

    public function deleteUser(Request $request)
    {
        $user =Admin::find($request->delete_user_id);
        if ($user->hasRole('SuperAdmin')) {
            return redirect()->route('admin.user.index')->with('error', 'Super Admin cannot be deleted');
        }
        $query = $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'User Deleted');
    }

    public function sendPasswordResetEmail($request)
    {

        $this->validateEmail($request);

        ResetPassword::$createUrlCallback = function ($notifiable,$token){
            return url(route('admin.password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        };

        ResetPassword::$toMailCallback = function($notifiable, $token){
            return (new MailMessage)
            ->subject(Lang::get('Welcome to '))
            ->greeting("Hello {$notifiable->name}!")
            ->line(Lang::get("You are invited on Seccuracy Platform. Use the click below to create your password and start working with {$notifiable->company?->name}"))
            ->action(Lang::get('Create Password'), url(route('admin.password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false)));        };
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );
    }

    public function broker()
    {
        return Password::broker('admins');
    }
}
