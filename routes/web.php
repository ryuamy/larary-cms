<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', [HomeController::class, 'index'] );

Auth::routes();

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

Route::get('/oauth2callback', [App\Http\Controllers\OAuthController::class, 'index'])->name('oauth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
