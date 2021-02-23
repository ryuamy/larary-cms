<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\Auth\LoginController;

Route::get( 'login', [LoginController::class, 'form'] )
    ->name( 'admin.login' );

Route::get( 'dashboard', [HomeController::class, 'index'] )
    ->name( 'admin.dashboard' );

Route::get( 'index', [HomeController::class, 'index'] )
    ->name( 'admin.index' );
 
Route::prefix( 'ajax' )->group(function () {
    Route::post( 'bulk-edit', [AjaxController::class, 'bulk_edit'] )
        ->name( 'admin.ajax.bulk_edit');
    Route::post( 'delete-data', [AjaxController::class, 'delete_data'] )
        ->name( 'admin.ajax.delete_data');
    Route::post( 'login', [AjaxController::class, 'login'] )
        ->name( 'admin.ajax.login' );
    Route::get( 'reload-captcha', [AjaxController::class, 'reload_captcha'] );
});

//** NOTES : buat Exports terlebih dahulu untuk mengaktifkan feature export */
Route::prefix( 'export' )->group(function () {
    // Route::get( 'excel/{table}', [ExportController::class, 'export_excel'] )
    //     ->name( 'admin.export.export_excel' );
    // Route::get( 'csv/{table}', [ExportController::class, 'export_csv'] )
    //     ->name( 'admin.export.export_csv' );
});

Route::prefix( 'sms' )->group(function () {
    Route::get( 'callback', [App\Http\Controllers\Admin\SmsController::class, 'callback'] );
});

Route::prefix( 'pages' )->group(function () {
    Route::get( '/', [PagesController::class, 'index'] );
    Route::get( 'create', [PagesController::class, 'create'] );
    Route::post( 'save', [PagesController::class, 'save'] );
    Route::get( 'detail/{uuid}', [PagesController::class, 'detail'] );
    Route::post( 'update/{uuid}', [PagesController::class, 'update'] );
});

Route::prefix( 'news' )->group(function () {
    Route::get( '/', [NewsController::class, 'index'] );
    Route::get( 'create', [NewsController::class, 'create'] );
    Route::post( 'save', [NewsController::class, 'save'] );
    Route::get( 'detail/{uuid}', [NewsController::class, 'detail'] );
    Route::post( 'update/{uuid}', [NewsController::class, 'update'] );
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