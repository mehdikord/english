<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
//    return \Illuminate\Support\Facades\Hash::make('123456');
    return view('front');
});

Route::get('system/responses/payment/failed',function (){
    return view('include.payment_failed');
})->name('reports_payment_failed');

Route::get('system/responses/payment/success',function (){
    return view('include.payment_success');
})->name('reports_payment_success');

Route::get('management', function () {
    return redirect('management/dashboard');
});

Route::get('management/{any}',static function (){
    return view('manage');
})->where('any','(.*)');

