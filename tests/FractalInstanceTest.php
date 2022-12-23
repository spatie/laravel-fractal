<?php

use Spatie\Fractal\Fractal;
use Spatie\Fractal\Test\Classes\FractalExtensionClass;
use Spatie\Fractal\Test\Classes\TestTransformer;
use Spatie\Fractalistic\ArraySerializer;

trait SetupFractalInstanceTest {
    protected function getEnvironmentSetUp($app)
    {
        $this->defaultSerializer = ArraySerializer::class;
        parent::getEnvironmentSetUp($app);
    }
}

uses(SetupFractalInstanceTest::class)->group('group');

beforeEach(function () {
    $this->fractal = $this->app->make(Fractal::class);
});

it('returns a default instance when resolving fractal using the container', function () {
    expect($this->app->make(Fractal::class))->toBeInstanceOf(Fractal::class);
});

it('returns a configured instance when resolving fractal using the container', function () {
    $this->app->forgetInstance('fractal');

    app('config')->set('fractal.fractal_class', FractalExtensionClass::class);

    expect($this->app->make(Fractal::class))->toBeInstanceOf(FractalExtensionClass::class);
});

it('uses the default serializer when it is specified', function () {
    $array = $this->fractal
        ->item($this->testBooks[0])
        ->transformWith(new TestTransformer())
        ->toArray();

    $expectedArray = ['id' => 1, 'author' => 'Philip K Dick'];

    expect($array)->toEqual($expectedArray);
});

it('can be extended via macros', function () {
    Fractal::macro('firstItem', function ($books) {
        return $this->item($books[0]);
    });

    $array = $this->fractal
        ->firstItem($this->testBooks)
        ->transformWith(new TestTransformer())
        ->toArray();

    $expectedArray = ['id' => 1, 'author' => 'Philip K Dick'];

    expect($array)->toEqual($expectedArray);
});
