<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

Route::get('/posts', [Controllers\PostController::class, 'index'])->name('index.home');
Route::get('/posts/create', [Controllers\PostController::class, 'create'])->name('create.post');
Route::post('/posts/store', [Controllers\PostController::class, 'store'])->name('store.post');
Route::get('/posts/show/{id}', [Controllers\PostController::class, 'show'])->name('show.post');
Route::get('/posts/edit/{id}', [Controllers\PostController::class, 'edit'])->name('edit.post');
Route::post('/posts/update/{id}', [Controllers\PostController::class, 'update'])->name('update.post');
Route::get('/posts/destroy/{id}', [Controllers\PostController::class, 'destroy'])->name('destroy.post');


