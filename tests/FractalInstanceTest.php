<?php

namespace Spatie\Fractal\Test;

use Spatie\Fractal\Fractal;
use Spatie\Fractalistic\ArraySerializer;

class FractalInstanceTest extends TestCase
{
    public function setUp($defaultSerializer = '')
    {
        parent::setup(ArraySerializer::class);

        $this->fractal = $this->app->make(Fractal::class);
    }

    /** @test */
    public function it_returns_a_default_instance_when_resolving_fractal_using_the_container()
    {
        $this->assertInstanceOf(Fractal::class, $this->app->make(Fractal::class));
    }

    /** @test */
    public function it_returns_a_configured_instance_when_resolving_fractal_using_the_container()
    {
        $this->app->forgetInstance('laravel-fractal');

        app('config')->set('laravel-fractal.fractal_class', FractalExtensionClass::class);

        $this->assertInstanceOf(FractalExtensionClass::class, $this->app->make(Fractal::class));
    }

    /** @test */
    public function it_uses_the_default_serializer_when_it_is_specified()
    {
        $array = $this->fractal
            ->item($this->testBooks[0])
            ->transformWith(new TestTransformer())
            ->toArray();

        $expectedArray = ['id' => 1, 'author' => 'Philip K Dick'];

        $this->assertEquals($expectedArray, $array);
    }
}
