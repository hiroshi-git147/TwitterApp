<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\Interfaces\ProfileServiceInterface;
use App\Services\Interfaces\TweetServiceInterface;
use App\Services\UserService;
use App\Services\ProfileService;
use App\Services\TweetService;

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
        //
    }
}
