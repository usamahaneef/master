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
            
        });
    }
);