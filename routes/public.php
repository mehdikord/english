<?php
//All public (non auth) data is here
use Illuminate\Support\Facades\Route;

Route::prefix('episodes')->group(function (){

   Route::get('',[\App\Http\Controllers\Public\Episodes\EpisodeController::class,'index']);

});
