<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * / 投稿一覧
 * /tweets/create  投稿作成画面
 * /tweets/show  投稿詳細画面
 * /tweets/edit  投稿編集画面
 */
Route::middleware('auth')->prefix('tweets')->name('tweets.')->group(function () {
    // ビューを返すルート
    Route::get('/create', [TweetController::class, 'create'])->name('create');
    Route::get('/{tweet}', [TweetController::class, 'show'])->name('show');
    Route::get('/{tweet}/edit', [TweetController::class, 'edit'])->name('edit'); 
});

// JavaScriptからの非同期通信用のルートをここに定義します
Route::post('/api/tweets', [\App\Http\Controllers\Api\TweetController::class, 'store'])->middleware('auth')->name('tweets.store.api');

// 認証不要なルート
Route::prefix('tweets')->name('tweets.')->group(function () {
    Route::get('/', [TweetController::class, 'index'])->name('index');
});




require __DIR__.'/auth.php';
