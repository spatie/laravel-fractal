<?php

namespace Spatie\Fractal;

use Illuminate\Support\ServiceProvider;
use Spatie\Fractal\Console\Commands\TransformerMakeCommand;

class FractalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/config/laravel-fractal.php' => config_path('laravel-fractal.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                TransformerMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../resources/config/laravel-fractal.php', 'laravel-fractal');

        $this->app->bind('laravel-fractal', function (...$arguments) {
            return fractal(...$arguments);
        });
    }
}
