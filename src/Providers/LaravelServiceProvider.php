<?php

namespace Spatie\Fractal\Providers;

class LaravelServiceProvider extends FractalServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->publishes([
            __DIR__ . '/../../resources/config/laravel-fractal.php' => config_path('laravel-fractal.php'),
        ], 'config');
    }
}
