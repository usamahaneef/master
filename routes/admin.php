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

Route::post('/admin/partners/store', [\App\Http\Controllers\Admin\PartnersController::class, 'store'])->name('admin.partners.store');
Route::post('/admin/partner/email/check', [\App\Http\Controllers\Admin\PartnersController::class, 'emailCheck'])->name('admin.partners.email.check');
Route::get('/admin/move-users-to-societies-user-table', [\App\Http\Controllers\Admin\DashboardController::class, 'moveUsersFromAdminTableToSocietyUser'])->name('admin.move.admins');

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
            /**
             * Route universities
            */
            Route::get('/admin/universities', [\App\Http\Controllers\Admin\UniversityController::class, 'index'])->name('universities');
            Route::get('/admin/university/create', [\App\Http\Controllers\Admin\UniversityController::class, 'create'])->name('universities.create');
            Route::post('/admin/university/store', [\App\Http\Controllers\Admin\UniversityController::class, 'store'])->name('universities.store');
            Route::get('/admin/university/edit/{university}', [\App\Http\Controllers\Admin\UniversityController::class, 'edit'])->name('universities.edit');
            Route::post('/admin/university/update/{university}', [\App\Http\Controllers\Admin\UniversityController::class, 'update'])->name('universities.update');
            Route::get('/admin/university/detail/{university}', [\App\Http\Controllers\Admin\UniversityController::class, 'detail'])->name('universities.detail');
            Route::delete('/admin/university/delete/{university}', [\App\Http\Controllers\Admin\UniversityController::class, 'delete'])->name('universities.delete');

            /**
             * Route Societies
             */
            Route::get('/admin/societies', [\App\Http\Controllers\Admin\SocietiesController::class, 'index'])->name('societies');
            Route::get('/admin/society/create', [\App\Http\Controllers\Admin\SocietiesController::class, 'create'])->name('societies.create');
            Route::post('/admin/society/store', [\App\Http\Controllers\Admin\SocietiesController::class, 'store'])->name('societies.store');
            Route::get('/admin/society/edit/{society}', [\App\Http\Controllers\Admin\SocietiesController::class, 'edit'])->name('societies.edit');
            Route::post('/admin/society/update/{society}', [\App\Http\Controllers\Admin\SocietiesController::class, 'update'])->name('societies.update');
            Route::get('/admin/society/detail/{society}', [\App\Http\Controllers\Admin\SocietiesController::class, 'detail'])->name('societies.detail');
            Route::delete('/admin/society/delete/{society}', [\App\Http\Controllers\Admin\SocietiesController::class, 'delete'])->name('societies.delete');
            /**Societies executive route */
                Route::get('/admin/societies/{society}/executive/add', [\App\Http\Controllers\Admin\SocietiesController::class,'executiveCreate'])->name('societies.executive.create');
                Route::post('/admin/societies/{society}/executive/store', [\App\Http\Controllers\Admin\SocietiesController::class,'executiveStore'])->name('societies.executive.store');
                Route::get('/admin/societies/{society}/executive/{executive}/edit', [\App\Http\Controllers\Admin\SocietiesController::class,'executiveEdit'])->name('societies.executive.edit');
                Route::post('/admin/societies/{society}/executive/{executive}/update', [\App\Http\Controllers\Admin\SocietiesController::class,'executiveUpdate'])->name('societies.executive.update');
                Route::get('/admin/societies/{society}/executive/{executive}/delete', [\App\Http\Controllers\Admin\SocietiesController::class,'executiveDelete'])->name('societies.executive.delete');
            /**
             * Route users
            */
            Route::get('/admin/students', [\App\Http\Controllers\Admin\UsersController::class, 'index'])->name('users');
            Route::get('/admin/student/detail/{user}', [\App\Http\Controllers\Admin\UsersController::class, 'detail'])->name('users.detail');
            Route::post('/admin/student/status/{user}', [\App\Http\Controllers\Admin\UsersController::class, 'status'])->name('users.status');
            Route::delete('/admin/student/{user}', [\App\Http\Controllers\Admin\UsersController::class, 'delete'])->name('users.delete');
            
            /**
             * Route Venues
             */
            Route::get('/admin/venues', [\App\Http\Controllers\Admin\VenuesController::class, 'index'])->name('venues');
            Route::get('/admin/venue/create', [\App\Http\Controllers\Admin\VenuesController::class, 'create'])->name('venues.create');
            Route::post('/admin/venue/store', [\App\Http\Controllers\Admin\VenuesController::class, 'store'])->name('venues.store');
            Route::get('/admin/venue/edit/{venue}', [\App\Http\Controllers\Admin\VenuesController::class, 'edit'])->name('venues.edit');
            Route::get('/admin/venue/detail/{venue}', [\App\Http\Controllers\Admin\VenuesController::class, 'detail'])->name('venues.detail');
            Route::post('/admin/venue/update/{venue}', [\App\Http\Controllers\Admin\VenuesController::class, 'update'])->name('venues.update');
            Route::get('/admin/venue/gallery/{venue}/{image}', [\App\Http\Controllers\Admin\VenuesController::class, 'gallery'])->name('venues.gallery');
            Route::delete('/admin/venue/delete/{venue}', [\App\Http\Controllers\Admin\VenuesController::class, 'delete'])->name('venues.delete');
            /**
             * Route Events
             */
            Route::get('/admin/events', [\App\Http\Controllers\Admin\EventsController::class, 'index'])->name('events');
            Route::get('/admin/event/create', [\App\Http\Controllers\Admin\EventsController::class, 'create'])->name('events.create');
            Route::post('/admin/event/store', [\App\Http\Controllers\Admin\EventsController::class, 'store'])->name('events.store');
            Route::get('/admin/event/edit/{event}', [\App\Http\Controllers\Admin\EventsController::class, 'edit'])->name('events.edit');
            Route::get('/admin/event/detail/{event}', [\App\Http\Controllers\Admin\EventsController::class, 'detail'])->name('events.detail');
            Route::post('/admin/event/update/{event}', [\App\Http\Controllers\Admin\EventsController::class, 'update'])->name('events.update');
            Route::get('/admin/event/gallery/{event}/{image}', [\App\Http\Controllers\Admin\EventsController::class, 'gallery'])->name('events.gallery');
            Route::delete('/admin/event/delete/{event}', [\App\Http\Controllers\Admin\EventsController::class, 'delete'])->name('events.delete');
            /**
             * Issues Route
             */
            Route::get('/admin/user-suggestions', [\App\Http\Controllers\Admin\UserSuggestionsController::class, 'index'])->name('user.suggestions');
            Route::get('/admin/user-suggestions/{issue}', [\App\Http\Controllers\Admin\UserSuggestionsController::class, 'details'])->name('user.suggestion.detail');
            Route::get('/admin/user-suggestions/{issue}/resolve', [\App\Http\Controllers\Admin\UserSuggestionsController::class, 'resolveIssue'])->name('user.suggestion.resolve');
            /**
             * Route Partners
             */
            Route::get('/admin/partners', [\App\Http\Controllers\Admin\PartnersController::class, 'index'])->name('partners');
            Route::get('/admin/partner/detail/{partner}', [\App\Http\Controllers\Admin\PartnersController::class, 'detail'])->name('partners.detail');
            Route::get('/admin/partner/create-society/{partner}', [\App\Http\Controllers\Admin\PartnersController::class, 'createSociety'])->name('partners.create.society');
            Route::post('/admin/partner/create-society/{partner}', [\App\Http\Controllers\Admin\PartnersController::class, 'storeSociety']);
            Route::delete('/admin/partner/delete/{partner}', [\App\Http\Controllers\Admin\PartnersController::class, 'delete'])->name('partners.delete');
            // setting
            Route::get('/admin/setting', [\App\Http\Controllers\Admin\SettingController::class,'index'])->name('setting');
            Route::post('/admin/setting/update', [\App\Http\Controllers\Admin\SettingController::class,'update'])->name('setting-update');
        });
    }
);