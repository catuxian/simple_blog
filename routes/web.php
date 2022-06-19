<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

Route::get('/',function() {
    return "首頁";
})->name('home');

/*會員頁面*/
Route::middleware(['auth','verified'])->prefix('post')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('user_home');//會員首頁
    Route::get('/create', [PostController::class, 'create'])->name('post.create');//新增文章
    Route::post('/store', [PostController::class, 'store'])->name('post.store');//儲存文章
    Route::get('/{id}/edit', [PostController::class, 'edit'])->name('post.edit');//編輯文章頁面
    Route::put('/{id}', [PostController::class, 'update'])->name('post.update');//更新文章
    Route::delete('/{id}', [PostController::class, 'destroy'])->name('post.destroy');//刪除文章
});

/*註冊*/
Route::prefix('register')->group(function() {
    Route::get('/', [RegisterController::class, 'index'])->name('register');
    Route::post('/add_account', [RegisterController::class, 'add_account'])->name('add_account');
});

/*驗證email*/
Route::get('/email/verify', function () {return view('auth.verify-email');})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) { $request->fulfill(); return redirect(route('user_home'));})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {return back()->with('message', '驗證信件已寄出!');})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/*登入*/
Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login',[LoginController::class, 'login'])->name('login');
Route::get('logout',[LoginController::class, 'logout'])->name('logout');
