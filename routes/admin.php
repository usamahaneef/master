<?php

use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
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

Route::name('admin.')->group(
    function () {
        Route::middleware('guest:admin')->group(function () {
            // Route::view('/admin/login', 'auth.admin.login')->name('login');
            Route::view('/admin/login', 'auth.admin.login')->name('login');
            Route::post('/admin/login', [AuthController::class, 'login']);

            Route::get('admin/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
            Route::post('admin/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('forgot.password.send-email');
            Route::get('admin/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
            Route::post('admin/reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');
        });
        Route::middleware('auth:admin')->group(function () {
            // Route::fallback(function () {
            //     return redirect()->back();
            // });
            Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('/admin/update-password', [AuthController::class, 'updatePassword'])->name('update-password');
            Route::post('/admin/store-password', [AuthController::class, 'storePassword'])->name('store-password');
            Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            /**
             * Admin Roles Routes
             */
            Route::get('admin/role/', [\App\Http\Controllers\Admin\General\RoleController::class, 'index'])->name('roles');
            Route::post('admin/role/add', [App\Http\Controllers\Admin\General\RoleController::class, 'AddNewRole'])->name('role.add');
            Route::post('admin/role/update', [App\Http\Controllers\Admin\General\RoleController::class, 'updateRole'])->name('role.update');
            Route::delete('admin/role/delete', [App\Http\Controllers\Admin\General\RoleController::class, 'deleteRole'])->name('role.delete');

            Route::prefix('admin/{role}')->group(function () {
                Route::prefix('/permissions')->name('role.permissions.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Admin\General\RoleController::class, 'rolePermissions'])->name('index');
                    Route::post('/', [App\Http\Controllers\Admin\General\RoleController::class, 'updateRolePermissions']);
                });
            });
            /**
             * Admin Users Routes
             */
            Route::get('admin/users', [App\Http\Controllers\Admin\General\UserController::class, 'index'])->name('user.index');
            Route::post('admin/user/add', [App\Http\Controllers\Admin\General\UserController::class, 'addNewUser'])->name('user.add');
            Route::get('admin/user/edit', [App\Http\Controllers\Admin\General\UserController::class, 'editUser'])->name('user.edit');
            Route::post('admin/user/update', [App\Http\Controllers\Admin\General\UserController::class, 'updateUser'])->name('user.update');
            Route::delete('admin/user/delete', [App\Http\Controllers\Admin\General\UserController::class, 'deleteUser'])->name('user.delete');

            Route::prefix('admin/user/{user}')->group(function () {
                Route::prefix('/permissions')->name('user.permissions.')->group(function () {
                    Route::get('/create', [App\Http\Controllers\Admin\General\PermissionController::class, 'userPermissions'])->name('create');
                    Route::post('/societies/store', [App\Http\Controllers\Admin\General\PermissionController::class, 'societiesPermissions'])->name('societies');
                    Route::post('/venues/store', [App\Http\Controllers\Admin\General\PermissionController::class, 'venuesPermissions'])->name('venues');
                    // Route::post('/', [App\Http\Controllers\Admin\General\RoleController::class, 'updateRolePermissions']);
                });
            });

            // setting
            Route::get('/admin/setting', [\App\Http\Controllers\Admin\SettingController::class,'index'])->name('setting');
            Route::post('/admin/setting/update', [\App\Http\Controllers\Admin\SettingController::class,'update'])->name('setting-update');
        });
    }
);