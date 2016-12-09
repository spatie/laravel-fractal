<?php

namespace Spatie\Fractal\Test;

use Spatie\Fractalistic\Fractal;
use Fractal as FractalFacade;

class FractalFacadeTest extends TestCase
{
    /** @test */
    public function it_returns_an_instance_of_fractal()
    {
        $this->assertInstanceOf(Fractal::class, FractalFacade::collection([]));
    }

    /** @test */
    public function it_can_transform_the_given_array_with_the_given_closure()
    {
        $transformedData = FractalFacade::collection(['item1', 'item2'], function ($item) {
            return $item.'-transformed';
        })->toArray();

        $this->assertEquals([
            'data' => ['item1-transformed', 'item2-transformed'],
        ], $transformedData);
    }
}
