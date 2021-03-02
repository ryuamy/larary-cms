<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\Auth\LoginController;

Route::get( 'login', [LoginController::class, 'form'] )
    ->name( 'admin.login' )
    ->middleware('admin');

Route::get( 'dashboard', [HomeController::class, 'index'] )
    ->name( 'admin.dashboard' )
    ->middleware('admin');

Route::get( 'index', [HomeController::class, 'index'] )
    ->name( 'admin.index' )
    ->middleware('admin');
 
Route::prefix( 'ajax' )->group(function () {
    Route::post( 'bulk-edit', [AjaxController::class, 'bulk_edit'] )
        ->name( 'admin.ajax.bulk_edit')
        ->middleware('admin');
    Route::post( 'delete-data', [AjaxController::class, 'delete_data'] )
        ->name( 'admin.ajax.delete_data')
        ->middleware('admin');
    Route::post( 'login', [AjaxController::class, 'login'] )
        ->name( 'admin.ajax.login' )
        ->middleware('admin');
    Route::get( 'reload-captcha', [AjaxController::class, 'reload_captcha'] )
        ->middleware('admin');
});

//** NOTES : buat Exports terlebih dahulu untuk mengaktifkan feature export */
Route::prefix( 'export' )->group(function () {
    // Route::get( 'excel/{table}', [ExportController::class, 'export_excel'] )
    //     ->name( 'admin.export.export_excel' );
    // Route::get( 'csv/{table}', [ExportController::class, 'export_csv'] )
    //     ->name( 'admin.export.export_csv' );
});

Route::prefix( 'sms' )->group(function () {
    Route::get( 'callback', [App\Http\Controllers\Admin\SmsController::class, 'callback'] )
        ->middleware('admin');
});

Route::prefix( 'pages' )->group(function () {
    Route::get( '/', [PagesController::class, 'index'] )
        ->middleware('admin');
    Route::get( 'create', [PagesController::class, 'create'] )
        ->middleware('admin');
    Route::post( 'save', [PagesController::class, 'save'] )
        ->middleware('admin');
    Route::get( 'detail/{uuid}', [PagesController::class, 'detail'] )
        ->middleware('admin');
    Route::post( 'update/{uuid}', [PagesController::class, 'update'] )
        ->middleware('admin');
});

Route::prefix( 'news' )->group(function () {
    Route::get( '/', [NewsController::class, 'index'] )
        ->middleware('admin');
    Route::get( 'create', [NewsController::class, 'create'] )
        ->middleware('admin');
    Route::post( 'save', [NewsController::class, 'save'] )
        ->middleware('admin');
    Route::get( 'detail/{uuid}', [NewsController::class, 'detail'] )
        ->middleware('admin');
    Route::post( 'update/{uuid}', [NewsController::class, 'update'] )
        ->middleware('admin');
});

// for skeleton
Route::prefix( 'custom' )->group(function () {
    Route::prefix( 'apps' )->group(function () {
        Route::prefix( 'user' )->group(function () {
            Route::get( 'list-default', [App\Http\Controllers\Admin\Custom\Apps\UserController::class, 'list_default'] );
            Route::get( 'list-datatable', [App\Http\Controllers\Admin\Custom\Apps\UserController::class, 'list_datatable'] );
        });
    });
});