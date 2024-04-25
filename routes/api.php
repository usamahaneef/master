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

Route::post('dummy/array' ,[\App\Http\Controllers\Api\DummyController::class, 'dummy']);

Route::post('user/signup',[\App\Http\Controllers\Api\AuthController::class, 'signup']);
Route::post('user/login',[\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('user/forgot-password',[\App\Http\Controllers\Api\AuthController::class, 'forgotPassword']);
Route::post('user/otp-verify',[\App\Http\Controllers\Api\AuthController::class, 'otpVerify']);
Route::post('user/reset-password',[\App\Http\Controllers\Api\AuthController::class, 'resetPassword']);
Route::post('user/verify-email',[\App\Http\Controllers\Api\AuthController::class, 'verifyEmail']);
Route::post('user/login-with-otp',[\App\Http\Controllers\Api\AuthController::class, 'loginWithOTP']);
Route::get('user/email/verify/{id}/{hash}', [\App\Http\Controllers\Api\AuthController::class, 'verify'])->name('verification.verify');

Route::get('universities/list',[\App\Http\Controllers\Api\UniversityController::class, 'index']);
Route::get('societies-on-signup/list',[\App\Http\Controllers\Api\SocietiesController::class, 'listSocieties']);

Route::middleware('auth:user_api')->group(function(){
    Route::get('dashboard',[App\Http\Controllers\Api\DashboardController::class, 'index']);
    Route::get('/user/logout/{id}', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    /**Societies routes */
    Route::get('societies/list',[App\Http\Controllers\Api\SocietiesController::class, 'index']);
    Route::get('society/detail/{id}',[App\Http\Controllers\Api\SocietiesController::class, 'detail']);
    Route::get('society/join',[App\Http\Controllers\Api\SocietiesController::class, 'joinSociety']);
    Route::get('society/member/notification/{id}',[App\Http\Controllers\Api\SocietiesController::class, 'toggleSocietyMemberNotifications']);
    Route::get('society/leave',[App\Http\Controllers\Api\SocietiesController::class, 'leaveSociety']);

    /**Student Profile */   
    Route::post('user/profile/{id}',[\App\Http\Controllers\Api\AuthController::class, 'profile']);
    Route::post('user/update-profile',[\App\Http\Controllers\Api\AuthController::class, 'updateProfile']);
    Route::post('user/update-password/{id}',[\App\Http\Controllers\Api\AuthController::class, 'updatePassword']);
    Route::post('user/update-username/{id}',[\App\Http\Controllers\Api\AuthController::class, 'updateUsername']);

    /** Venue Routes */
    Route::get('venues/list',[App\Http\Controllers\Api\VenuesController::class, 'index']);
    Route::get('venue/detail/{id}',[App\Http\Controllers\Api\VenuesController::class, 'detail']);

    /** Events Routes  */
    Route::get('events/list',[App\Http\Controllers\Api\EventsController::class, 'index']);
    Route::get('event/detail/{id}',[App\Http\Controllers\Api\EventsController::class, 'detail']);
    Route::get('delete-account',[App\Http\Controllers\Api\AuthController::class, 'deleteMyAccount']);
    /** Receive notification non-society-user */
    Route::get('event/subscribe/{id}',[App\Http\Controllers\Api\EventsController::class, 'subscribe']);
    
    /** Report Issue Route  */
    Route::get('report-issue',[App\Http\Controllers\Api\ReportIssuesController::class, 'reportIssues']);
    /** Notifications Routes  */
    
    Route::get('notifications/list',[App\Http\Controllers\Api\NotificationsController::class, 'index']);
    Route::get('notification/detail/{id}',[App\Http\Controllers\Api\NotificationsController::class, 'detail']);
    Route::get('notification/read/{id}',[App\Http\Controllers\Api\NotificationsController::class, 'read']);
    Route::get('notification/read-all',[App\Http\Controllers\Api\NotificationsController::class, 'readAllNotifications']);
    
    Route::get('check-verification-status', [\App\Http\Controllers\Api\AuthController::class, 'checkVerificationStatus']);
});

