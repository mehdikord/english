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
    Route::prefix('life')->as('life')->group(function (){
        Route::get('',[\App\Http\Controllers\User\Life\LifeController::class,'index']);
        Route::delete('',[\App\Http\Controllers\User\Life\LifeController::class,'delete']);
        Route::post('buy',[\App\Http\Controllers\User\Life\LifeController::class,'buy']);
    });
    Route::prefix('packs')->group(function (){

        Route::get('',[\App\Http\Controllers\User\Life\LifeController::class,'pack_index']);
        Route::post('buy/{pack}',[\App\Http\Controllers\User\Life\LifeController::class,'pack_buy']);

    });

    Route::prefix('episodes')->group(function (){
        Route::get('',[\App\Http\Controllers\User\Episodes\EpisodeController::class,'index']);
        Route::get('active',[\App\Http\Controllers\User\Episodes\EpisodeController::class,'active']);
        Route::post('buy/{episode}',[\App\Http\Controllers\User\Episodes\EpisodeController::class,'buy']);
        Route::get('download/{episode}',[\App\Http\Controllers\User\Episodes\EpisodeController::class,'download']);
        Route::prefix('set')->group(function (){
            Route::get('active/{episode}',[\App\Http\Controllers\User\Episodes\EpisodeController::class,'set_active'])->name('set.active');
            Route::get('done/{episode}',[\App\Http\Controllers\User\Episodes\EpisodeController::class,'set_done'])->name('set.done');
            Route::post('level/{episode}',[\App\Http\Controllers\User\Episodes\EpisodeController::class,'set_level'])->name('set.level');
        });

    });

    Route::prefix('payments')->group(function (){

        Route::get('zarinpal_callback',[\App\Http\Controllers\User\Invoice\InvoiceController::class,'callback_zarinpal'])->withoutMiddleware('auth:users');

    });




});


