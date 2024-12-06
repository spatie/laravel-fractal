<?php

namespace Spatie\Fractal\Test;

use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Fractal\FractalServiceProvider;
use Spatie\Fractal\Test\Classes\TestTransformer;

abstract class TestCase extends Orchestra
{
    /** @var \Spatie\Fractal\Fractal */
    protected $fractal;

    /** @var array */
    protected $testBooks;

    /** @var string|\League\Fractal\Serializer\SerializerAbstract */
    protected $defaultSerializer;

    /** @var string|\League\Fractal\Pagination\PaginatorInterface */
    protected $defaultPaginator;

    protected function setUp(): void
    {
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

        $this->setupRoutes();
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
        if ($this->defaultSerializer != '') {
            $app['config']->set('fractal.default_serializer', $this->defaultSerializer);
        }

        if ($this->defaultPaginator != '') {
            $app['config']->set('fractal.default_paginator', $this->defaultPaginator);
        }
    }

    protected function setupRoutes()
    {
        Route::get('auto-includes', function () {
            return fractal()
                ->collection($this->testBooks)
                ->transformWith(TestTransformer::class)
                ->toArray();
        });

        Route::get('auto-fieldsets-with-resource-name', function () {
            return fractal()
                ->withResourceName('books')
                ->collection($this->testBooks)
                ->transformWith(TestTransformer::class)
                ->toArray();
        });

        Route::get('auto-fieldsets-without-resource-name', function () {
            return fractal()
                ->collection($this->testBooks)
                ->transformWith(TestTransformer::class)
                ->toArray();
        });
    }
}
