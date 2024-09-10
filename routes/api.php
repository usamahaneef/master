<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('user/signup',[\App\Http\Controllers\Api\AuthController::class, 'signup']);
Route::post('user/login',[\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('user/forgot-password',[\App\Http\Controllers\Api\AuthController::class, 'forgotPassword']);
Route::post('user/otp-verify',[\App\Http\Controllers\Api\AuthController::class, 'otpVerify']);
Route::post('user/reset-password',[\App\Http\Controllers\Api\AuthController::class, 'resetPassword']);
Route::post('user/verify-email',[\App\Http\Controllers\Api\AuthController::class, 'verifyEmail']);
Route::post('user/login-with-otp',[\App\Http\Controllers\Api\AuthController::class, 'loginWithOTP']);
Route::get('user/email/verify/{id}/{hash}', [\App\Http\Controllers\Api\AuthController::class, 'verify'])->name('verification.verify');

Route::middleware('auth:user_api')->group(function(){
    Route::get('dashboard',[App\Http\Controllers\Api\DashboardController::class, 'index']);
    Route::get('/user/logout/{id}', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    /**Societies routes */
    
    Route::get('check-verification-status', [\App\Http\Controllers\Api\AuthController::class, 'checkVerificationStatus']);
});

