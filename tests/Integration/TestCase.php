<?php

namespace Spatie\Fractal\Test\Integration;

use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Fractal\Fractal;
use Spatie\Fractal\Providers\LaravelServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * @var \Spatie\Fractal\Fractal
     */
    protected $fractal;

    /**
     * @var array
     */
    protected $testBooks;

    /**
     * @var string
     */
    protected $defaultSerializer;

    public function setUp($defaultSerializer = '')
    {
        $this->defaultSerializer = $defaultSerializer;

        parent::setUp();

        $this->fractal = $this->app->make(Fractal::class);

        $this->testBooks = [
            [
                'id' => '1',
                'title' => 'Hogfather',
                'yr' => '1998',
                'author_name' => 'Philip K Dick',
                'author_email' => 'philip@example.org',
                'characters' => [['name' => 'Death'], ['name' => 'Hex']],
                'publisher' => 'Elephant books',
            ],
            [
                'id' => '2',
                'title' => 'Game Of Kill Everyone',
                'yr' => '2014',
                'author_name' => 'George R. R. Satan',
                'author_email' => 'george@example.org',
                'characters' => [['name' => 'Ned Stark'], ['name' => 'Tywin Lannister']],
                'publisher' => 'Bloody Fantasy inc.',
            ],
        ];
    }
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [LaravelServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Fractal' => 'Spatie\Fractal\FractalFacade',
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        if ($this->defaultSerializer != '') {
            $app['config']->set('laravel-fractal.default_serializer', $this->defaultSerializer);
        }
    }
}
