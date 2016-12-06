<?php

namespace Spatie\Fractal;

use League\Fractal\Manager;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Serializer\SerializerAbstract;

class FractalLumenServiceProvider extends ServiceProvider
{
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
    }

    /**
     * Set the default serializer.
     *
     * @param \Spatie\Fractal\Fractal                              $fractal
     * @param string|\League\Fractal\Serializer\SerializerAbstract $serializer
     *
     * @return mixed
     */
    protected function setDefaultSerializer(Fractal $fractal, $serializer)
    {
        if ($serializer instanceof SerializerAbstract) {
            return $fractal->serializeWith($serializer);
        }

        return $fractal->serializeWith(new $serializer());
    }
}
