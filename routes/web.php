<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
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
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');
});

/*好友*/
Route::middleware(['auth','verified'])->prefix('friends')->group(function () {
    Route::get('/list', [FriendController::class, 'friend_list'])->name('friend_list');//好友清單
    Route::get('/invitations', [FriendController::class, 'friend_invitations'])->name('friend_invitations');//好友邀請
    Route::post('/add/{id}', [FriendController::class, 'add_friend'])->name('add_friend');//新增好友
    Route::post('/delete/{id}', [FriendController::class, 'delete_friend'])->name('delete_friend');//刪除好友
    Route::post('/cancel_invitation/{to_id}', [FriendController::class, 'cancel_invitation'])->name('cancel_invitation');//取消好友邀請
    Route::post('/decline_invitation/{from_id}', [FriendController::class, 'decline_invitation'])->name('decline_invitation');//拒絕好友邀請
    Route::post('/accept_invitation/{from_id}', [FriendController::class, 'accept_invitation'])->name('accept_invitation');//接受好友邀請
});

/*會員頁面*/
Route::middleware(['auth','verified'])->prefix('user')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('user_home');//會員首頁
    Route::get('/create', [PostController::class, 'create'])->name('posts.create');//新增留言
    Route::post('/store', [PostController::class, 'store'])->name('posts.store');//儲存留言
    Route::get('/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');//編輯留言頁面
    Route::put('/{id}', [PostController::class, 'update'])->name('posts.update');//更新留言
    Route::delete('/{id}', [PostController::class, 'destroy'])->name('posts.destroy');//刪除留言
    Route::get('/search', [UserController::class, 'search_user'])->name('search_user');//搜尋用戶
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

