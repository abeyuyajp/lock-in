<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

// 会員登録
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');

// ログイン
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

// ログアウト
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// ログインユーザー
Route::get('/user', fn() => \Auth::user())->name('user');



// 投稿機能
Route::post('/posts', [App\Http\Controllers\PostController::class, 'create'])->name('posts.create');

// 投稿一覧
Route::get('/posts', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');

// 投稿詳細
Route::get('/posts/{id}', [App\Http\Controllers\PostController::class, 'show'])->name('posts.show');

// コメント
Route::post('/posts/{post}/comments', [App\Http\Controllers\PostController::class, 'addComment'])->name('posts.comment');

// いいね
Route::post('/posts/{id}/like', [App\Http\Controllers\PostController::class, 'like'])->name('posts.like');

// いいね解除
Route::delete('/posts/{id}/like',  [App\Http\Controllers\PostController::class, 'unlike'])->name('posts.delete');
