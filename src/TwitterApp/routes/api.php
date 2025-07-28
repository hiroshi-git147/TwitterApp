<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VerificationCodeController;
use App\Http\Controllers\Api\TweetController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 認証コード検証API（認証不要）
Route::post('/verify-code', [VerificationCodeController::class, 'verify']);

// 認証コード再送信API (認証不要、ただし回数制限あり)
Route::post('/resend-verification-code', [VerificationCodeController::class, 'resend'])
    ->middleware('throttle:6,1');

// 認証不要なルート
Route::prefix('tweets')->name('api.tweets.')->group(function () {
    Route::get('/', [TweetController::class, 'index'])->name('index');
});

// 認証が必要なルート
Route::middleware('auth:sanctum')->prefix('tweets')->name('api.tweets.')->group(function () {
    Route::get('/{tweet}', [TweetController::class, 'show'])->name('show');
    Route::delete('/{tweet}', [TweetController::class, 'destroy'])->name('destroy');
});
