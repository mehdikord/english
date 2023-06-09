<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Management Routes
|--------------------------------------------------------------------------
|
| all management (admins) routes is here
|
*/

//Authenticate
Route::prefix('auth')->group(function (){
    Route::post('login',[\App\Http\Controllers\Manage\Auth\AuthController::class,'manage_login'])->name('auth.login');
});

//enable auth middleware for authenticate
Route::middleware('auth:admin')->group(function (){

    //Dashboard
    Route::group(['prefix' => 'dashboard','as' => 'dashboard.'],function (){
        Route::get('counts',[\App\Http\Controllers\Manage\Dashboard\DashboardController::class,'counts'])->name('counts');
        Route::get('latest/users',[\App\Http\Controllers\Manage\Dashboard\DashboardController::class,'latest_users'])->name('latest_users');
        Route::get('latest/invoices',[\App\Http\Controllers\Manage\Dashboard\DashboardController::class,'latest_invoices'])->name('latest_invoices');


    });

    //authenticated user
    Route::prefix('me')->group(function (){
        Route::get('',[\App\Http\Controllers\Manage\Profile\ProfileController::class,'me'])->name('me');

    });

    //Members and Managers
    Route::group(['prefix' => 'users','as' => 'users.'],function (){
       Route::group(['prefix' => 'managers','as' => 'managers.'],function (){
           Route::get('',[\App\Http\Controllers\Manage\Users\UserController::class,'managers_index'])->name('index');
           Route::post('',[\App\Http\Controllers\Manage\Users\UserController::class,'managers_store'])->name('store');
           Route::post('{admin}',[\App\Http\Controllers\Manage\Users\UserController::class,'managers_update'])->name('update');
           Route::delete('{admin}',[\App\Http\Controllers\Manage\Users\UserController::class,'managers_delete'])->name('delete');
       });

       Route::group(['prefix' => 'members','as' => 'members.'],function (){
            Route::get('',[\App\Http\Controllers\Manage\Users\UserController::class,'members_index'])->name('index');
            Route::post('',[\App\Http\Controllers\Manage\Users\UserController::class,'members_store'])->name('store');
            Route::get('activation/{user}',[\App\Http\Controllers\Manage\Users\UserController::class,'members_activation'])->name('activation');
            Route::post('{user}',[\App\Http\Controllers\Manage\Users\UserController::class,'members_update'])->name('update');
            Route::delete('{user}',[\App\Http\Controllers\Manage\Users\UserController::class,'members_delete'])->name('delete');
       });

    });

    //Faqs
    Route::group(['prefix' => 'faqs','as' => 'faqs.'],function (){
        Route::get('',[\App\Http\Controllers\Manage\Faqs\FaqsController::class,'index'])->name('index');
        Route::post('',[\App\Http\Controllers\Manage\Faqs\FaqsController::class,'store'])->name('store');
        Route::post('{faq}',[\App\Http\Controllers\Manage\Faqs\FaqsController::class,'update'])->name('update');
        Route::delete('{faq}',[\App\Http\Controllers\Manage\Faqs\FaqsController::class,'delete'])->name('delete');

    });

    //Packs
    Route::group(['prefix' => 'packs','as' => 'packs.'],function (){
        Route::get('',[\App\Http\Controllers\Manage\Packs\PackController::class,'index'])->name('index');
        Route::post('',[\App\Http\Controllers\Manage\Packs\PackController::class,'store'])->name('store');
        Route::post('{pack}',[\App\Http\Controllers\Manage\Packs\PackController::class,'update'])->name('update');
        Route::delete('{pack}',[\App\Http\Controllers\Manage\Packs\PackController::class,'delete'])->name('delete');

    });

    //Episodes
    Route::group(['prefix' => 'episodes','as' => 'episodes.'],function (){
        Route::get('',[\App\Http\Controllers\Manage\Episodes\EpisodesController::class,'index'])->name('index');
        Route::post('',[\App\Http\Controllers\Manage\Episodes\EpisodesController::class,'store'])->name('store');
        Route::get('activation/{episode}',[\App\Http\Controllers\Manage\Episodes\EpisodesController::class,'activation'])->name('activation');
        Route::post('{episode}',[\App\Http\Controllers\Manage\Episodes\EpisodesController::class,'update'])->name('update');
        Route::delete('{episode}',[\App\Http\Controllers\Manage\Episodes\EpisodesController::class,'delete'])->name('delete');
        Route::get('download/{episode}',[\App\Http\Controllers\Manage\Episodes\EpisodesController::class,'download'])->name('download');

    });

    //Invoice
    Route::group(['prefix' => 'invoices','as' => 'invoices.'],function (){

        Route::get('',[\App\Http\Controllers\Manage\Invoices\InvoiceController::class,'index'])->name('index');
        Route::post('',[\App\Http\Controllers\Manage\Invoices\InvoiceController::class,'store'])->name('store');
        Route::get('change/payment/{invoice}',[\App\Http\Controllers\Manage\Invoices\InvoiceController::class,'change_payment'])->name('change_payment');


    });

    //Configs
    Route::group(['prefix' => 'configs','as' => 'configs.'],function (){

        Route::get('',[\App\Http\Controllers\Manage\Configs\ConfigsController::class,'index'])->name('index');
        Route::post('{config}',[\App\Http\Controllers\Manage\Configs\ConfigsController::class,'update'])->name('update');
        Route::get('set/default',[\App\Http\Controllers\Manage\Configs\ConfigsController::class,'default'])->name('default');


    });




});


