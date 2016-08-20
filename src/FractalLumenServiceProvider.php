<?php

namespace Spatie\Fractal;

use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;
use League\Fractal\Serializer\SerializerAbstract;

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

            if (! empty($config['default_serializer'])) {
                $fractal = $this->setDefaultSerializer($fractal, $config['default_serializer']);
            }

            return $fractal;
        });

        $this->app->alias(Fractal::class, 'laravel-fractal');

        include __DIR__.'/helpers.php';
    }

    /**
     * Set the default serializer.
     *
     * @param \Spatie\Fractal\Fractal                              $fractal
     * @param string|\League\Fractal\Serializer\SerializerAbstract $serializer
     *
     * @return mixed
     */
    protected function setDefaultSerializer($fractal, $serializer)
    {
        if ($serializer instanceof SerializerAbstract) {
            return $fractal->serializeWith($serializer);
        }

        return $fractal->serializeWith(new $serializer());
    }
}
