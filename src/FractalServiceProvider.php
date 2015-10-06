<?php

namespace Spatie\Skeleton;

use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../resources/config/laravel-fractal.php', 'laravel-fractal');

        $this->app->bind('laravel-fractal', function () {
            $fractal = $this->app(\Spatie\Fractal\Fractal::class);

            $fractal->setOutputFormat($this->app['config']->get('laravel-fractal.default_output_format'));

            return $fractal;
        });
    }
}
