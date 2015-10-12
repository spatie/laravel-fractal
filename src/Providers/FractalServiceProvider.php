<?php

namespace Spatie\Fractal\Providers;

use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;
use Spatie\Fractal\Fractal;

class FractalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
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

        include __DIR__ . '/../helpers.php';
    }

    /**
     * Setup the configuration.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../resources/config/laravel-fractal.php', 'laravel-fractal');
    }
}
