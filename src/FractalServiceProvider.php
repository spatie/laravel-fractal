<?php

namespace Spatie\Fractal;

use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;

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

        $this->app->bind(Fractal::class, function () {

            $manager = new Manager();

            $fractal = new Fractal($manager);

            $config = $this->app['config']->get('laravel-fractal');

            if ($config['default_serializer'] != '') {
                $fractal->serializeWith(new $config['default_serializer']());
            }

            return $fractal;
        });

        $this->app->alias(Fractal::class, 'laravel-fractal');

        include __DIR__.'/helpers.php';
    }
}
