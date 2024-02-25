<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\PaymentPlanController;
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
            Route::view('/admin', 'auth.admin.login')->name('login');
            Route::view('/admin/login', 'auth.admin.login')->name('login');
            Route::post('/admin/login', [AuthController::class, 'login']);
        });
        Route::middleware('auth:admin')->group(function () {
            // Route::fallback(function () {
            //     return redirect()->back();
            // });
            Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            /*
             hospital Routes
            */
            Route::get('/admin/hospitals', [\App\Http\Controllers\Admin\HospitalController::class, 'index'])->name('hospitals');
            Route::get('/admin/hospital/create', [\App\Http\Controllers\Admin\HospitalController::class, 'create'])->name('hospital.create');
            Route::post('/admin/hospital/create', [\App\Http\Controllers\Admin\HospitalController::class, 'store'])->name('hospital.create');
            Route::get('/admin/hospital/{hospital}/details', [\App\Http\Controllers\Admin\HospitalController::class, 'show'])->name('hospital.details');
            Route::get('/admin/hospital/{hospital}/edit', [\App\Http\Controllers\Admin\HospitalController::class, 'edit'])->name('hospital.edit');
            Route::post('/admin/hospital/{hospital}/edit', [\App\Http\Controllers\Admin\HospitalController::class, 'update'])->name('hospital.edit');
            Route::delete('/admin/hospital/{hospital}/delete', [\App\Http\Controllers\Admin\HospitalController::class, 'destroy'])->name('hospital.delete');
        });
    }
);
