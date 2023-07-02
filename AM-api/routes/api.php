<?php

use App\Http\Controllers\V1\AuthenticationController;
use App\Http\Controllers\V1\FormController;
use App\Http\Controllers\V1\ProjectController;
use App\Http\Controllers\V1\UserController;
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

Route::middleware('auth:sanctum')->group(function(){

    
    Route::post("v1/auth/logout",[AuthenticationController::class,"logout"]);
    Route::post("v1/auth/reset-password",[AuthenticationController::class,"resetPassword"]);
    Route::post("v1/user/form",[FormController::class,"create_form"]);
    Route::get("v1/user/my-forms",[FormController::class,"getMyForms"]);
    Route::put("v1/user/form/{id}",[FormController::class,"editForm"]);
    Route::get("v1/user/my-account",[UserController::class,"myAccount"]);
    Route::post("v1//user/form/send-invitation",[FormController::class,"sendInvitation"]);
    Route::post("v1/user/form/check-invitation",[FormController::class,"checkInvitation"]);
    
    Route::get("v1/user/form/submissions/{id}",[FormController::class,"getSubmissionsData"]);

});
Route::post("v1/user/form/submit",[FormController::class,"submission"]);
Route::get("v1/user/form/{id}",[FormController::class,"getOneForm"]);
Route::post("v1/auth/login",[AuthenticationController::class,"login"]);
Route::post("v1/auth/verify-otp",[AuthenticationController::class,"verifyOtp"]);
Route::post("v1/auth/regenerate-otp",[AuthenticationController::class,"regenerateOtp"]);
Route::post("v1/user/signup",[UserController::class,"signup"]);