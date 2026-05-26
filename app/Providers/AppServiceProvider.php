<?php

namespace App\Providers;

use App\Contracts\Repositories\ArticleRepositoryInterface;
use App\Contracts\Repositories\TagRepositoryInterface;
use App\Repositories\V1\ArticleRepository;
use App\Repositories\V1\TagRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ArticleRepositoryInterface::class,
            ArticleRepository::class
        );

        $this->app->bind(
            TagRepositoryInterface::class,
            TagRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
