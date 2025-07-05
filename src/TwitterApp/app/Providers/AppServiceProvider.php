<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\Interfaces\ProfileServiceInterface;
use App\Services\Interfaces\TweetServiceInterface;
use App\Services\UserService;
use App\Services\ProfileService;
use App\Services\TweetService;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ValidationList;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(ProfileServiceInterface::class, ProfileService::class);
        $this->app->bind(TweetServiceInterface::class, TweetService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('japanese', function ($attribute, $value, $parameters, $validator) {
            // ValidationList::japaneseChars() から正規表現を取得し、regex ルールを適用
            $pattern = '/' . substr(ValidationList::japaneseChars(), 6) . '/u'; // 'regex:' 部分を削除
            return preg_match($pattern, $value);
        }, '日本語と一部の記号のみで入力してください。'); // カスタムメッセージ
    }
}
