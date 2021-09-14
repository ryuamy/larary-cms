<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Application\HomeController;
use App\Http\Controllers\Application\SitemapController;
use App\Http\Controllers\Application\TestController;
use App\Http\Controllers\Application\Auth\LoginController;
use App\Http\Controllers\Application\Auth\GoogleController;
use App\Http\Controllers\OAuthController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get( '/', [HomeController::class, 'index'] );
Route::get( '/home', [HomeController::class, 'index'] )->name('home');

Route::get( '/login', [LoginController::class, 'form'] )->name('login');
Route::get( '/login/google', [GoogleController::class, 'redirect'] );
Route::get( '/login/google/callback', [GoogleController::class, 'callback'] );
Route::get( '/logout', [LoginController::class, 'logout'] );

Route::get( '/sitemap.xml', [SitemapController::class, 'sitemap'] );

Route::get( '/oauth2callback', [OAuthController::class, 'index'] )->name('oauth');


Route::get( 'test', [TestController::class, 'index'] );
Route::get( 'xxx', [TestController::class, 'test'] );

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
