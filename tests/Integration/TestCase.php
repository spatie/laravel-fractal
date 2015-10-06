<?php

namespace Spatie\Fractal\Test\Integration;

use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Fractal\FractalServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();
    }
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [FractalServiceProvider::class];
    }
}
