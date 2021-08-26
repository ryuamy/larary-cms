<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\AdminrolesController;
use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\News\NewsController;
use App\Http\Controllers\Admin\News\NewscategoriesController;
use App\Http\Controllers\Admin\News\NewstagsController;
use App\Http\Controllers\Admin\Settings\GeneralSettingsController;
use App\Http\Controllers\Admin\Settings\MetaSettingsController;

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

// TODO : buat Exports terlebih dahulu untuk mengaktifkan feature export
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
    Route::get('/', [PagesController::class, 'index'] )->name('adm_pages_index');
    Route::get('create', [PagesController::class, 'create'] )->name('adm_pages_create');
    Route::get('save', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('save', [PagesController::class, 'save'] )->name('adm_pages_save');
    Route::get('detail/{uuid}', [PagesController::class, 'detail'] )->name('adm_pages_detail');
    Route::get('update/{uuid}', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::get('update', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('update/{uuid}', [PagesController::class, 'update'] )->name('adm_pages_update');
});

Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index'] )->name('adm_news_index');
    Route::get('create', [NewsController::class, 'create'] )->name('adm_news_create');
    Route::get('save', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('save', [NewsController::class, 'save'] )->name('adm_news_save');
    Route::get('detail/{uuid}', [NewsController::class, 'detail'] )->name('adm_news_detail');
    Route::get('update/{uuid}', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::get('update', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('update/{uuid}', [NewsController::class, 'update'] )->name('adm_news_update');

    Route::prefix('categories')->group(function () {
        Route::get('/', [NewscategoriesController::class, 'index'] )->name('adm_news_categories_index');
        Route::get('create', [NewscategoriesController::class, 'create'] )->name('adm_news_categories_create');
        Route::get('save', function() {
            return view('errors.404', array('message'=>'404 | Page Not Found!') );
        });
        Route::post('save', [NewscategoriesController::class, 'save'] )->name('adm_news_categories_save');
        Route::get('detail/{uuid}', [NewscategoriesController::class, 'detail'] )->name('adm_news_categories_detail');
        Route::get('update/{uuid}', function() {
            return view('errors.404', array('message'=>'404 | Page Not Found!') );
        });
        Route::get('update', function() {
            return view('errors.404', array('message'=>'404 | Page Not Found!') );
        });
        Route::post('update/{uuid}', [NewscategoriesController::class, 'update'] )->name('adm_news_categories_update');
    });

    Route::prefix('tags')->group(function () {
        Route::get('/', [NewstagsController::class, 'index'] )->name('adm_news_tags_index');
        Route::get('create', [NewstagsController::class, 'create'] )->name('adm_news_tags_create');
        Route::get('save', function() {
            return view('errors.404', array('message'=>'404 | Page Not Found!') );
        });
        Route::post('save', [NewstagsController::class, 'save'] )->name('adm_news_tags_save');
        Route::get('detail/{uuid}', [NewstagsController::class, 'detail'] )->name('adm_news_tags_detail');
        Route::get('update/{uuid}', function() {
            return view('errors.404', array('message'=>'404 | Page Not Found!') );
        });
        Route::get('update', function() {
            return view('errors.404', array('message'=>'404 | Page Not Found!') );
        });
        Route::post('update/{uuid}', [NewstagsController::class, 'update'] )->name('adm_news_tags_update');
    });
});

Route::prefix('admins')->group(function () {
    Route::get('/', [AdminsController::class, 'index'] )->name('adm_admins_index');
    Route::get('create', [AdminsController::class, 'create'] )->name('adm_admins_create');
    Route::get('save', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('save', [AdminsController::class, 'save'] )->name('adm_admins_save');
    Route::get('detail/{uuid}', [AdminsController::class, 'detail'] )->name('adm_admins_detail');
    Route::get('update/{uuid}', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::get('update', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('update/{uuid}', [AdminsController::class, 'update'] )->name('adm_admins_update');
});

Route::prefix('admin-roles')->group(function () {
    Route::get('/', [AdminrolesController::class, 'index'] )->name('adm_admin_roles_index');
    Route::get('create', [AdminrolesController::class, 'create'] )->name('adm_admin_roles_create');
    Route::get('save', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('save', [AdminrolesController::class, 'save'] )->name('adm_admin_roles_save');
    Route::get('detail/{uuid}', [AdminrolesController::class, 'detail'] )->name('adm_admin_roles_detail');
    Route::get('update/{uuid}', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::get('update', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('update/{uuid}', [AdminrolesController::class, 'update'] )->name('adm_admin_roles_update');
});

Route::prefix('settings')->group(function () {
    Route::get('general', [GeneralSettingsController::class, 'detail'] )->name('adm_settings_general');
    Route::get('general/update', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('general/update', [GeneralSettingsController::class, 'update'] )->name('adm_settings_general_update');

    Route::get('meta-website', [MetaSettingsController::class, 'detail'] )->name('adm_settings_general');
    Route::get('meta-website/update', function() {
        return view('errors.404', array('message'=>'404 | Page Not Found!') );
    });
    Route::post('meta-website/update', [MetaSettingsController::class, 'update'] )->name('adm_settings_general_update');
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
