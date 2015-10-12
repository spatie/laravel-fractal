<?php

namespace Spatie\Fractal\Providers;

class LumenServiceProvider extends FractalServiceProvider
{
    /**
     * Setup the configuration.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $this->app->configure('laravel-fractal');

        parent::setupConfig();
    }
}
