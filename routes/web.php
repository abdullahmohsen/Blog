<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => 'verified'], function () {

    Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function()
    {

        Route::get('/youtube', [Controllers\PostController::class, 'getVideo'])->name('youtube.video');


        Route::get('/home', [Controllers\PostController::class, 'index'])->name('index.home');
        Route::get('/posts/create', [Controllers\PostController::class, 'create'])->name('create.post');
        Route::post('/posts/store', [Controllers\PostController::class, 'store'])->name('store.post');
        Route::get('/posts/show/{id}', [Controllers\PostController::class, 'show'])->name('show.post');
        Route::get('/posts/edit/{id}', [Controllers\PostController::class, 'edit'])->name('edit.post');
        Route::post('/posts/update/{id}', [Controllers\PostController::class, 'update'])->name('update.post');
        Route::get('/posts/destroy/{id}', [Controllers\PostController::class, 'destroy'])->name('destroy.post');

        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('verified')->name('index.home');


        //CRUD AJAX
        Route::group(['prefix' => 'ajax-posts'], function () {
            // Route::get('home', [Controllers\CrudAjaxController::class, 'index'])->name('index.ajaxpost');
            //Route::get('create', [Controllers\CrudAjaxController::class, 'create'])->name('create.ajaxpost');
            Route::post('store', [Controllers\CrudAjaxController::class, 'store'])->name('store.ajaxpost');
            //Route::get('edit/{post_id}', [Controllers\CrudAjaxController::class, 'edit'])->name('edit.ajaxpost');
            Route::post('update', [Controllers\CrudAjaxController::class, 'update'])->name('update.ajaxpost');
            Route::post('destroy', [Controllers\CrudAjaxController::class, 'destroy'])->name('destroy.ajaxpost');

        });

        Route::get('/categories', [Controllers\CategoryController::class, 'index'])->name('home.category');
        Route::get('/categories/create', [Controllers\CategoryController::class, 'create'])->name('create.category');

    });
});

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function()
{
    Auth::routes(['verify'=>true]);

});

