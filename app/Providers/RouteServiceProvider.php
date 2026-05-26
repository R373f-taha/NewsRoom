<?php

namespace App\Providers;

use App\Models\Article;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       Route::bind('article',function($value){
            return Article::withoutGlobalScopes(['visibility'])->findOrFail($value);
        });
    }
}
