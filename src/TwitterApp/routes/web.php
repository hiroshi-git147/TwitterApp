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
 * /tweets 投稿一覧
 * /tweets/tweet 投稿詳細
 * /tweets/tweetSubmit 投稿送信
 * /tweets/editTweet 投稿編集
 * /tweets/updateTweet 投稿更新
 * /tweets/deleteTweet 投稿削除
 * /tweets/search 検索
 */
Route::middleware('auth')->prefix('tweets')->name('tweets.')->group(function () {
    Route::get('/', [TweetController::class, 'index'])->name('index');
    Route::get('/create', [TweetController::class, 'create'])->name('create');
    Route::post('/', [TweetController::class, 'store'])->name('store');
    Route::get('/{tweet}', [TweetController::class, 'show'])->name('show');
    Route::get('/{tweet}/edit', [TweetController::class, 'edit'])->name('edit');
    Route::patch('/{tweet}', [TweetController::class, 'update'])->name('update');
    Route::delete('/{tweet}', [TweetController::class, 'destroy'])->name('destroy');
    Route::get('/search', [TweetController::class, 'search'])->name('search'); // 検索は一旦そのまま
});


require __DIR__.'/auth.php';
