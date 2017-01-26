<?php

namespace Spatie\Fractal\Test;

use Spatie\Fractalistic\ArraySerializer;
use Spatie\Fractal\Fractal;

class FractalInstanceTest extends TestCase
{
    public function setUp($defaultSerializer = '')
    {
        parent::setup(ArraySerializer::class);

        $this->fractal = $this->app->make(Fractal::class);
    }
    /** @test */
    public function it_returns_an_instance_of_fractal_when_using_app_make()
    {
        $this->assertInstanceOf(Fractal::class, $this->app->make(Fractal::class));
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