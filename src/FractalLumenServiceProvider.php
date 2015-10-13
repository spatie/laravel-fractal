<?php

namespace Spatie\Fractal;

use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;

class FractalLumenServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->configure('laravel-fractal');

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

        include __DIR__ . '/helpers.php';
    }
}
