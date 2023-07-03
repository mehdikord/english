<?php
//All public (non auth) data is here
use Illuminate\Support\Facades\Route;

Route::prefix('episodes')->group(function (){

   Route::get('',[\App\Http\Controllers\Public\Episodes\EpisodeController::class,'index']);
   Route::get('download/{episode}',[\App\Http\Controllers\Public\Episodes\EpisodeController::class,'download']);

});
Route::prefix('config')->group(function (){
   Route::get('app/version',[\App\Http\Controllers\Public\ConfigController::class,'version']);
});
