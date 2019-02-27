<?php

namespace Spatie\Fractal\Test;

use Spatie\Fractal\Fractal;
use Spatie\Fractalistic\ArraySerializer;

class FractalInstanceTest extends TestCase
{
    public function setUp($defaultSerializer = '', $defaultPaginator = ''): void
    {
        parent::setUp(ArraySerializer::class);

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
        $this->app->forgetInstance('fractal');

        app('config')->set('fractal.fractal_class', FractalExtensionClass::class);

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

    /** @test */
    public function it_can_be_extended_via_macros()
    {
        Fractal::macro('firstItem', function ($books) {
            return $this->item($books[0]);
        });

        $array = $this->fractal
            ->firstItem($this->testBooks)
            ->transformWith(new TestTransformer())
            ->toArray();

        $expectedArray = ['id' => 1, 'author' => 'Philip K Dick'];

        $this->assertEquals($expectedArray, $array);
    }
}
