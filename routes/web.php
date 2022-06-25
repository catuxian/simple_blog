<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FriendController;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

/*首頁*/
Route::get('/', [HomeController::class, 'home'])->name('home');

/*好友*/
Route::middleware(['auth','verified'])->prefix('friends')->group(function () {
    Route::get('/search', [FriendController::class, 'search_friend'])->name('search_friend');//搜尋好友
    Route::post('/add', [FriendController::class, 'add_friend'])->name('add_friend');//新增好友
});

/*會員頁面*/
Route::middleware(['auth','verified'])->prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('user_home');//會員首頁
    Route::get('/create', [PostController::class, 'create'])->name('posts.create');//新增文章
    Route::post('/store', [PostController::class, 'store'])->name('posts.store');//儲存文章
    Route::get('/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');//編輯文章頁面
    Route::put('/{id}', [PostController::class, 'update'])->name('posts.update');//更新文章
    Route::delete('/{id}', [PostController::class, 'destroy'])->name('posts.destroy');//刪除文章
});

/*註冊*/
Route::prefix('register')->group(function() {
    Route::get('/', [RegisterController::class, 'index'])->name('register');
    Route::post('/add_account', [RegisterController::class, 'add_account'])->name('add_account');
});

/*登入*/
Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login',[LoginController::class, 'login'])->name('login');
Route::get('logout',[LoginController::class, 'logout'])->name('logout');

/*驗證email*/
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) { 
    $request->fulfill(); 

    return redirect(route('user_home'));
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification(); 

    return back()->with('message', '驗證信件已寄出!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/*忘記密碼*/
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
 
    $status = Password::sendResetLink(
        $request->only('email')
    );
    
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
 
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
 
    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

