<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OAuthController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', [HomeController::class, 'index'] );

/** phpinfo */
// Route::get( 'phpinfo', function() {
//     return phpinfo();
// });

/** clear cache on shared hosting */
Route::get( '/route-cache', function() {
    Artisan::call('route:cache');
    return view( 'clearcache.main', array('message'=>'Route cache cleared!') );
});
Route::get( '/config-cache', function() {
    Artisan::call('config:cache');
    return view( 'clearcache.main', array('message'=>'Config cache cleared!') );
});
Route::get( '/clear-cache', function() {
    Artisan::call('clear:cache');
    return view( 'clearcache.main', array('message'=>'Application cache cleared!') );
});
Route::get( '/view-cache', function() {
    Artisan::call('view:cache');
    return view( 'clearcache.main', array('message'=>'View cache cleared!') );
});

Route::get('/oauth2callback', [OAuthController::class, 'index'])->name('oauth');

Route::get('/home', [HomeController::class, 'index'])->name('home');
