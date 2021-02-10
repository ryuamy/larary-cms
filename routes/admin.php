<?php

use Illuminate\Support\Facades\Route;

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

Route::get( 'login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'form'] )
    ->name('admin.login');

Route::get( 'dashboard', [App\Http\Controllers\Admin\HomeController::class, 'index'] )
    ->name('admin.dashboard');

    
Route::prefix( 'ajax' )->group(function () {
    Route::post( 'bulk-edit', [App\Http\Controllers\Admin\AjaxController::class, 'bulk_edit'] )
        ->name("admin.ajax.bulk_edit");
    Route::post( 'delete-data', [App\Http\Controllers\Admin\AjaxController::class, 'delete_data'] )
        ->name("admin.ajax.delete_data");
    Route::post( 'login', [App\Http\Controllers\Admin\AjaxController::class, 'login'] )
        ->name("admin.ajax.login");
});

Route::prefix( 'export' )->group(function () {
    Route::get( 'excel/{table}', [App\Http\Controllers\Admin\ExportController::class, 'export_excel'] )
        ->name("admin.export.export_excel");
    Route::get("csv/{table}", [App\Http\Controllers\Admin\ExportController::class, 'export_csv'] )
        ->name("admin.export.export_csv");
});