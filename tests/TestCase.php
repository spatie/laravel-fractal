<?php

namespace Spatie\Fractal\Test;

use Spatie\Fractal\FractalServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /** @var \Spatie\Fractal\Fractal */
    protected $fractal;

    /** @var array */
    protected $testBooks;

    /** @var string|\League\Fractal\Serializer\SerializerAbstract */
    protected $defaultSerializer;

    /** @var  @var string|\League\Fractal\Paginator\Paginator\PaginatorInterface */
    protected $defaultPaginator;

    public function setUp($defaultSerializer = '', $defaultPaginator = '')
    {
        $this->defaultSerializer = $defaultSerializer;
        $this->defaultPaginator = $defaultPaginator;

        parent::setUp();

        $this->fractal = fractal();

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

    protected function getPackageProviders($app)
    {
        return [FractalServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Fractal' => 'Spatie\Fractal\FractalFacade',
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        if ($this->defaultSerializer !== '') {
            $app['config']->set('laravel-fractal.default_serializer', $this->defaultSerializer);
        }

        if ($this->defaultPaginator !== '') {
            $app['config']->set('laravel-fractal.default_paginator', $this->defaultPaginator);
        }
    }
}
