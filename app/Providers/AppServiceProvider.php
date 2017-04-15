<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $view->with([
                'categories' => \App\Category::withCount('products')->get()
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (! $this->app->environment('production') !== 'production') {
            $this->app->register(
                \Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class
            );
        }
    }
}
