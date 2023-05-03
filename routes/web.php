<?php

use App\Http\Controllers\Admin\ArticalController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {
    Route::get('login', [LoginController::class, 'showLoginForm']);
    Route::get('/', [LoginController::class, 'showLoginForm']);
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');

    Route::group(['prefix' => 'admin'], function(){
        //route for creating a user to test the project password = password
        Route::get('/create-user', [LoginController::class, 'create']);

        Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');
        Route::get('dashboard', [HomeController::class, 'index'])->name('admin.dashboard');


        //users
        Route::group(['prefix' => 'users', 'as' => 'users.'], function (){
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/indexTable', [UserController::class, 'indexTable'])->name('indexTable');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::put('/{id}/update', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}/destroy', [UserController::class, 'destroy'])->name('destroy');
        });

        // Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => ['permission:show_users|create_users|edit_users|delete_users']], function (){
        //     Route::get('/', [UserController::class, 'index'])->name('index');
        //     Route::get('/indexTable', [UserController::class, 'indexTable'])->name('indexTable');
        //     Route::post('/', [UserController::class, 'store'])->name('store');
        //     Route::put('/{id}/update', [UserController::class, 'update'])->name('update');
        //     Route::delete('/{id}/destroy', [UserController::class, 'destroy'])->name('destroy');
        // });

        // articles
        Route::get('articles', [ArticalController::class, 'index'])->name('articles.index');
        Route::get('articles/indexTable', [ArticalController::class, 'indexTable'])->name('articles.indexTable');
        Route::post('articles', [ArticalController::class, 'store'])->name('articles.store');
        Route::put('articles/{id}/update', [ArticalController::class, 'update'])->name('articles.update');
        Route::delete('articles/{id}/destroy', [ArticalController::class, 'destroy'])->name('articles.destroy');

        // partners
        Route::get('partners', [PartnerController::class, 'index'])->name('partners.index');
        Route::get('partners/indexTable', [PartnerController::class, 'indexTable'])->name('partners.indexTable');
        Route::post('partners', [PartnerController::class, 'store'])->name('partners.store');
        Route::put('partners/{id}/update', [PartnerController::class, 'update'])->name('partners.update');
        Route::delete('partners/{id}/destroy', [PartnerController::class, 'destroy'])->name('partners.destroy');

        //sliders
        Route::get('sliders', [SliderController::class, 'index'])->name('sliders.index');
        Route::get('sliders/indexTable', [SliderController::class, 'indexTable'])->name('sliders.indexTable');
        Route::post('sliders', [SliderController::class, 'store'])->name('sliders.store');
        Route::put('sliders/{id}/update', [SliderController::class, 'update'])->name('sliders.update');
        Route::delete('sliders/{id}/destroy', [SliderController::class, 'destroy'])->name('sliders.destroy');

        //videos
        Route::get('videos', [VideoController::class, 'index'])->name('videos.index');
        Route::get('videos/indexTable', [VideoController::class, 'indexTable'])->name('videos.indexTable');
        Route::post('videos', [VideoController::class, 'store'])->name('videos.store');
        Route::put('videos/{id}/update', [VideoController::class, 'update'])->name('videos.update');
        Route::delete('videos/{id}/destroy', [VideoController::class, 'destroy'])->name('videos.destroy');

        //reports
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/indexTable', [ReportController::class, 'indexTable'])->name('reports.indexTable');
        Route::post('reports', [ReportController::class, 'store'])->name('reports.store');
        Route::put('reports/{id}/update', [ReportController::class, 'update'])->name('reports.update');
        Route::delete('reports/{id}/destroy', [ReportController::class, 'destroy'])->name('reports.destroy');
        // Route::get('reports/{id}/download', [ReportController::class, 'getDownload'])->name('reports.download');

        //programs
        Route::get('programs', [ProgramController::class, 'index'])->name('programs.index');
        Route::get('programs/indexTable', [ProgramController::class, 'indexTable'])->name('programs.indexTable');
        Route::post('programs', [ProgramController::class, 'store'])->name('programs.store');
        Route::put('programs/{id}/update', [ProgramController::class, 'update'])->name('programs.update');
        Route::delete('programs/{id}/destroy', [ProgramController::class, 'destroy'])->name('programs.destroy');

        Route::group(['prefix' => 'sections', 'as' => 'sections.'], function (){
            Route::get('/', [SectionController::class, 'index'])->name('index');
            Route::get('/indexTable', [SectionController::class, 'indexTable'])->name('indexTable');
            Route::post('', [SectionController::class, 'store'])->name('store');
            Route::put('/{id}/update', [SectionController::class, 'update'])->name('update');
            Route::delete('/{id}/destroy', [SectionController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'roles_manager', 'as' => 'roles_manager.'], function (){
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/indexTable', [RoleController::class, 'indexTable'])->name('indexTable');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::put('/{id}/update', [RoleController::class, 'update'])->name('update');
            Route::delete('/{id}/destroy', [RoleController::class, 'destroy'])->name('destroy');
        });

        //contacts
        Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
        Route::post('contacts', [SectionController::class, 'store'])->name('contacts.store');
        Route::get('contacts/indexTable', [ContactController::class, 'indexTable'])->name('contacts.indexTable');
    });
});
