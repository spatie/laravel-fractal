<?php

namespace Spatie\Fractal;

use Spatie\Fractalistic\Fractal;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Serializer\SerializerAbstract;
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

        $this->app->alias(Fractal::class, 'laravel-fractal');
    }

    /**
     * Set the default serializer.
     *
     * @param \Spatie\Fractal\Fractal                              $fractal
     * @param string|\League\Fractal\Serializer\SerializerAbstract $serializer
     *
     * @return \Spatie\Fractal\Fractal
     */
    protected function setDefaultSerializer($fractal, $serializer)
    {
        if ($serializer instanceof SerializerAbstract) {
            return $fractal->serializeWith($serializer);
        }

        return $fractal->serializeWith(new $serializer());
    }
}
