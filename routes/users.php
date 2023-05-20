<?php
use Illuminate\Support\Facades\Route;



//Authenticate
Route::prefix('auth')->group(function (){
    Route::post('register',[\App\Http\Controllers\User\Auth\AuthController::class,'register'])->name('auth.register');
    Route::post('login',[\App\Http\Controllers\User\Auth\AuthController::class,'login'])->name('auth.login');
    Route::prefix('sms')->group(function (){
       Route::post('login',[\App\Http\Controllers\User\Auth\AuthController::class,'sms_login'])->name('auth.sms.login');
       Route::post('check',[\App\Http\Controllers\User\Auth\AuthController::class,'sms_check'])->name('auth.sms.check');

    });

});


//enable auth middleware for authenticate
Route::middleware('auth:users')->group(function (){

    Route::prefix('profile')->as('profile')->group(function (){
        Route::get('',[\App\Http\Controllers\User\Profile\ProfileController::class,'me']);
        Route::post('',[\App\Http\Controllers\User\Profile\ProfileController::class,'update']);
    });


});


