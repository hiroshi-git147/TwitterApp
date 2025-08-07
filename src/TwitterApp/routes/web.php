<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\Api\TweetController as ApiTweetController;
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

Route::prefix('tweets')->name('tweets.')->group(function () {
    // ビューを返すルート
    Route::get('/', [TweetController::class, 'index'])->name('index');
});

Route::middleware('auth')
    ->prefix('/api/tweets')
    ->controller(ApiTweetController::class)
    ->name('tweets.')
    ->group(function() {
        Route::get('/', 'index')->name('index.api');
        Route::get('/{tweet}', 'show')->name('show.api');
        Route::post('/', 'store')->name('store.api');
        Route::get('/edit/{tweet}', 'store')->name('store.api');
        Route::patch('/update/{tweet}', 'update')->name('update.api');
        Route::delete('/delete/{tweet}', 'destroy')->name('destroy.api');
});

Route::controller(ApiTweetController::class)
    ->name('tweets.')
    ->group(function() {
        Route::get('/api/tweets/', 'index')->name('index.api');
});

require __DIR__.'/auth.php';
