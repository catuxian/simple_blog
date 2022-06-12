<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;

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

Route::middleware(['auth'])->prefix('post')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('admweb');//管理者首頁
    // Route::get('post/create', 'HomeController@create');
    // Route::post('post', 'HomeController@store');
    // Route::get('post/{id}', 'HomeController@show');
    // Route::get('post/{id}/edit', 'HomeController@edit');
    // Route::put('post/{id}', 'HomeController@update');
    // Route::delete('post/{id}', 'HomeController@destroy');
});

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login',[LoginController::class, 'login'])->name('login');
Route::get('logout',[LoginController::class, 'logout'])->name('logout');