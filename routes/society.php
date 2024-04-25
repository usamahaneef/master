<?php

use App\Http\Controllers\Society\Auth\ResetPasswordController;
use App\Http\Controllers\Society\AuthController;
use App\Http\Controllers\Society\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::name('society.')->group(
    function () {
        Route::middleware('guest:society')->group(function () {
            // Route::view('/society/login', 'auth.society.login')->name('login');
            Route::view('/society/login', 'auth.society.login')->name('login');
            Route::post('/society/login', [AuthController::class, 'login']);

            Route::get('society/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
            Route::post('society/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('forgot.password.send-email');
            Route::get('society/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
            Route::post('society/reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');
        });
        Route::middleware('auth:society')->group(function () {
            // Route::fallback(function () {
            //     return redirect()->back();
            // });
            Route::post('/society/logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('/society/update-password', [AuthController::class, 'updatePassword'])->name('update-password');
            Route::post('/society/store-password', [AuthController::class, 'storePassword'])->name('store-password');
            Route::get('/society/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            /**
             * Admin Roles Routes
             */
            Route::get('society/role/', [\App\Http\Controllers\Society\General\RoleController::class, 'index'])->name('roles');
            Route::post('society/role/add', [App\Http\Controllers\Society\General\RoleController::class, 'AddNewRole'])->name('role.add');
            Route::post('society/role/update', [App\Http\Controllers\Society\General\RoleController::class, 'updateRole'])->name('role.update');
            Route::delete('society/role/delete', [App\Http\Controllers\Society\General\RoleController::class, 'deleteRole'])->name('role.delete');

            Route::prefix('society/{role}')->group(function () {
                Route::prefix('/permissions')->name('role.permissions.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Society\General\RoleController::class, 'rolePermissions'])->name('index');
                    Route::post('/', [App\Http\Controllers\Society\General\RoleController::class, 'updateRolePermissions']);
                });
            });
            /**
             * Admin Users Routes
             */
            Route::get('society/users', [App\Http\Controllers\Society\General\UserController::class, 'index'])->name('user.index');
            Route::post('society/user/add', [App\Http\Controllers\Society\General\UserController::class, 'addNewUser'])->name('user.add');
            Route::get('society/user/edit', [App\Http\Controllers\Society\General\UserController::class, 'editUser'])->name('user.edit');
            Route::post('society/user/update', [App\Http\Controllers\Society\General\UserController::class, 'updateUser'])->name('user.update');
            Route::delete('society/user/delete', [App\Http\Controllers\Society\General\UserController::class, 'deleteUser'])->name('user.delete');

            Route::prefix('society/user/{user}')->group(function () {
                Route::prefix('/permissions')->name('user.permissions.')->group(function () {
                    Route::get('/create', [App\Http\Controllers\Society\General\PermissionController::class, 'userPermissions'])->name('create');
                    Route::post('/societies/store', [App\Http\Controllers\Society\General\PermissionController::class, 'societiesPermissions'])->name('societies');
                    Route::post('/venues/store', [App\Http\Controllers\Society\General\PermissionController::class, 'venuesPermissions'])->name('venues');
                    // Route::post('/', [App\Http\Controllers\Society\General\RoleController::class, 'updateRolePermissions']);
                });
            });
            
            /**
             * Route Societies
             */
            Route::get('/society/societies', [\App\Http\Controllers\Society\SocietiesController::class, 'index'])->name('societies');
            Route::get('/society/create', [\App\Http\Controllers\Society\SocietiesController::class, 'create'])->name('societies.create');
            Route::post('/society/store', [\App\Http\Controllers\Society\SocietiesController::class, 'store'])->name('societies.store');
            Route::get('/society/edit/{society}', [\App\Http\Controllers\Society\SocietiesController::class, 'edit'])->name('societies.edit');
            Route::post('/society/update/{society}', [\App\Http\Controllers\Society\SocietiesController::class, 'update'])->name('societies.update');
            Route::get('/society/detail/{society}', [\App\Http\Controllers\Society\SocietiesController::class, 'detail'])->name('societies.detail');
            Route::delete('/society/delete/{society}', [\App\Http\Controllers\Society\SocietiesController::class, 'delete'])->name('societies.delete');
            /**Societies executive route */
            Route::get('/society/societies/{society}/executive/add', [\App\Http\Controllers\Society\SocietiesController::class,'executiveCreate'])->name('societies.executive.create');
            Route::post('/society/societies/{society}/executive/store', [\App\Http\Controllers\Society\SocietiesController::class,'executiveStore'])->name('societies.executive.store');
            Route::get('/society/societies/{society}/executive/{executive}/edit', [\App\Http\Controllers\Society\SocietiesController::class,'executiveEdit'])->name('societies.executive.edit');
            Route::post('/society/societies/{society}/executive/{executive}/update', [\App\Http\Controllers\Society\SocietiesController::class,'executiveUpdate'])->name('societies.executive.update');
            Route::get('/society/societies/{society}/executive/{executive}/delete', [\App\Http\Controllers\Society\SocietiesController::class,'executiveDelete'])->name('societies.executive.delete');
            
            
            /**
             * Route Events
             */
            Route::get('/society/events', [\App\Http\Controllers\Society\EventsController::class, 'index'])->name('events');
            Route::get('/society/event/create', [\App\Http\Controllers\Society\EventsController::class, 'create'])->name('events.create');
            Route::post('/society/event/store', [\App\Http\Controllers\Society\EventsController::class, 'store'])->name('events.store');
            Route::get('/society/event/edit/{event}', [\App\Http\Controllers\Society\EventsController::class, 'edit'])->name('events.edit');
            Route::get('/society/event/detail/{event}', [\App\Http\Controllers\Society\EventsController::class, 'detail'])->name('events.detail');
            Route::post('/society/event/update/{event}', [\App\Http\Controllers\Society\EventsController::class, 'update'])->name('events.update');
            Route::get('/society/event/gallery/{event}/{image}', [\App\Http\Controllers\Society\EventsController::class, 'gallery'])->name('events.gallery');
            Route::delete('/society/event/delete/{event}', [\App\Http\Controllers\Society\EventsController::class, 'delete'])->name('events.delete');
            
            Route::get('/society/setting', [\App\Http\Controllers\Society\SettingController::class,'index'])->name('setting');
            Route::post('/society/setting/update', [\App\Http\Controllers\Society\SettingController::class,'update'])->name('setting-update');

            /**
             * Society Notifications
             */
            Route::get('/society/notifications', [\App\Http\Controllers\Society\NotificationsController::class, 'index'])->name('notifications');
            Route::get('/society/notification/create', [\App\Http\Controllers\Society\NotificationsController::class, 'create'])->name('notifications.create');
            Route::post('/society/notification/store', [\App\Http\Controllers\Society\NotificationsController::class, 'store'])->name('notifications.store');
            Route::get('/society/notification/edit/{notification}', [\App\Http\Controllers\Society\NotificationsController::class, 'edit'])->name('notifications.edit');
            Route::get('/society/notification/detail/{notification}', [\App\Http\Controllers\Society\NotificationsController::class, 'detail'])->name('notifications.detail');
            Route::post('/society/notification/update/{notification}', [\App\Http\Controllers\Society\NotificationsController::class, 'update'])->name('notifications.update');
            Route::get('/society/notification/gallery/{notification}/{image}', [\App\Http\Controllers\Society\NotificationsController::class, 'gallery'])->name('notifications.gallery');
            Route::delete('/society/notification/delete/{notification}', [\App\Http\Controllers\Society\NotificationsController::class, 'delete'])->name('notifications.delete');
            /**
             * Society Members
             */
            /**
             * Route users
            */
            Route::get('/society/members', [\App\Http\Controllers\Society\SociectyMembersController::class, 'index'])->name('members');
            Route::get('/society/member/detail/{user}', [\App\Http\Controllers\Society\SociectyMembersController::class, 'detail'])->name('members.detail');
            Route::post('/society/member/status/{user}', [\App\Http\Controllers\Society\SociectyMembersController::class, 'status'])->name('members.status');
            Route::delete('/society/member/{user}', [\App\Http\Controllers\Society\SociectyMembersController::class, 'delete'])->name('members.delete');
            
        });
    }
);