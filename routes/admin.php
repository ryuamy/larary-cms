<?php

use Illuminate\Support\Facades\Route;

Route::get( 'login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'form'] )
    ->name( 'admin.login' );

Route::get( 'dashboard', [App\Http\Controllers\Admin\HomeController::class, 'index'] )
    ->name( 'admin.dashboard' );

Route::get( 'index', [App\Http\Controllers\Admin\HomeController::class, 'index'] )
    ->name( 'admin.index' );
 
Route::prefix( 'ajax' )->group(function () {
    Route::post( 'bulk-edit', [App\Http\Controllers\Admin\AjaxController::class, 'bulk_edit'] )
        ->name( 'admin.ajax.bulk_edit');
    Route::post( 'delete-data', [App\Http\Controllers\Admin\AjaxController::class, 'delete_data'] )
        ->name( 'admin.ajax.delete_data');
    Route::post( 'login', [App\Http\Controllers\Admin\AjaxController::class, 'login'] )
        ->name( 'admin.ajax.login' );
});

//** NOTES : buat Exports terlebih dahulu untuk mengaktifkan feature export */
Route::prefix( 'export' )->group(function () {
    // Route::get( 'excel/{table}', [App\Http\Controllers\Admin\ExportController::class, 'export_excel'] )
    //     ->name( 'admin.export.export_excel' );
    // Route::get( 'csv/{table}', [App\Http\Controllers\Admin\ExportController::class, 'export_csv'] )
    //     ->name( 'admin.export.export_csv' );
});

Route::prefix( 'sms' )->group(function () {
    Route::get( 'callback', [App\Http\Controllers\Admin\SmsController::class, 'callback'] );
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