<?php
use Illuminate\Support\Facades\Route;



//Authenticate
Route::prefix('auth')->group(function (){
    Route::post('register',[\App\Http\Controllers\User\Auth\AuthController::class,'register'])->name('auth.register');
    Route::post('login',[\App\Http\Controllers\User\Auth\AuthController::class,'login'])->name('auth.login');
});


