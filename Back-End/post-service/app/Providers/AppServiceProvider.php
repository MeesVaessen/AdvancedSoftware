<?php

namespace App\Providers;

use App\Repositories\Interfaces\postRepositoryInterface;
use App\Repositories\postRepository;
use App\Services\Interfaces\postServiceInterface;
use App\Services\postService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(postRepositoryInterface::class, postRepository::class);
        $this->app->bind(postServiceInterface::class, postService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
