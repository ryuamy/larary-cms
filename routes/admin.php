<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\AdminrolesController;
use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\NewscategoriesController;
use App\Http\Controllers\Admin\NewstagsController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\Auth\LoginController;

// Auth::routes();

Route::get('login', [LoginController::class, 'form'] )->name('adm_login');

Route::get('logout', [LoginController::class, 'logout'])->name('adm_logout');

Route::get('dashboard', [HomeController::class, 'index'] )->name('adm_dashboard');

Route::get('index', [HomeController::class, 'index'] )->name('adm_index');
 
Route::prefix('ajax')->group(function () {
    Route::post('bulk-edit', [AjaxController::class, 'bulk_edit'] );
    Route::get('bulk-edit', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('delete-data', [AjaxController::class, 'delete_data'] );
    Route::get('delete-data', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('login', [AjaxController::class, 'login'] );
    Route::get('login', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::get('reload-captcha', [AjaxController::class, 'reload_captcha'] );
    Route::post('delete-file', [AjaxController::class, 'delete_file'] );
    Route::get('delete-file', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('detail-admin-log/{id}', [AjaxController::class, 'detail_admin_log'] );
});

//** NOTES : buat Exports terlebih dahulu untuk mengaktifkan feature export */
Route::prefix('export')->group(function () {
    // Route::get('excel/{table}', [ExportController::class, 'export_excel'] )
    //     ->name('admin.export.export_excel');
    // Route::get('csv/{table}', [ExportController::class, 'export_csv'] )
    //     ->name('admin.export.export_csv');
});

Route::prefix('sms')->group(function () {
    Route::get('callback', [App\Http\Controllers\Admin\SmsController::class, 'callback'] );
});

Route::prefix('pages')->group(function () {
    Route::get('/', [PagesController::class, 'index'] );
    Route::get('create', [PagesController::class, 'create'] );
    Route::get('save', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('save', [PagesController::class, 'save'] );
    Route::get('detail/{uuid}', [PagesController::class, 'detail'] );
    Route::get('update/{uuid}', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::get('update', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('update/{uuid}', [PagesController::class, 'update'] );
});

Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index'] );
    Route::get('create', [NewsController::class, 'create'] );
    Route::get('save', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('save', [NewsController::class, 'save'] );
    Route::get('detail/{uuid}', [NewsController::class, 'detail'] );
    Route::get('update/{uuid}', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::get('update', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('update/{uuid}', [NewsController::class, 'update'] );
        
    Route::prefix('categories')->group(function () {
        Route::get('/', [NewscategoriesController::class, 'index'] );
        Route::get('create', [NewscategoriesController::class, 'create'] );
        Route::get('save', function() {
            return view('errors.404', array('message'=>'404 | Page Not Found!') );
        });
        Route::post('save', [NewscategoriesController::class, 'save'] );
        Route::get('detail/{uuid}', [NewscategoriesController::class, 'detail'] );
        Route::get('update/{uuid}', function() {
            return view('errors.404', array('message'=>'404 | Page Not Found!') );
        });
        Route::get('update', function() {
            return view('errors.404', array('message'=>'404 | Page Not Found!') );
        });
        Route::post('update/{uuid}', [NewscategoriesController::class, 'update'] );
    });
        
    Route::prefix('tags')->group(function () {
        Route::get('/', [NewstagsController::class, 'index'] );
        Route::get('create', [NewstagsController::class, 'create'] );
        Route::get('save', function() {
            return view('errors.404', array('message'=>'404 | Page Not Found!') );
        });
        Route::post('save', [NewstagsController::class, 'save'] );
        Route::get('detail/{uuid}', [NewstagsController::class, 'detail'] );
        Route::get('update/{uuid}', function() {
            return view('errors.404', array('message'=>'404 | Page Not Found!') );
        });
        Route::get('update', function() {
            return view('errors.404', array('message'=>'404 | Page Not Found!') );
        });
        Route::post('update/{uuid}', [NewstagsController::class, 'update'] );
    });
});

Route::prefix('admins')->group(function () {
    Route::get('/', [AdminsController::class, 'index'] );
    Route::get('create', [AdminsController::class, 'create'] );
    Route::get('save', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('save', [AdminsController::class, 'save'] );
    Route::get('detail/{uuid}', [AdminsController::class, 'detail'] );
    Route::get('update/{uuid}', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::get('update', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('update/{uuid}', [AdminsController::class, 'update'] );
});

Route::prefix('admin-roles')->group(function () {
    Route::get('/', [AdminrolesController::class, 'index'] );
    Route::get('create', [AdminrolesController::class, 'create'] );
    Route::get('save', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('save', [AdminrolesController::class, 'save'] );
    Route::get('detail/{uuid}', [AdminrolesController::class, 'detail'] );
    Route::get('update/{uuid}', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::get('update', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('update/{uuid}', [AdminrolesController::class, 'update'] );
});

// for skeleton
Route::prefix('custom')->group(function () {
    Route::prefix('apps')->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('list-default', [App\Http\Controllers\Admin\Custom\Apps\UserController::class, 'list_default'] );
            Route::get('list-datatable', [App\Http\Controllers\Admin\Custom\Apps\UserController::class, 'list_datatable'] );
        });
    });
});