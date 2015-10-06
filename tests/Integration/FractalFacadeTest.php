<?php

namespace Spatie\Fractal\Test\Integration;

use Fractal;

class FractalFacadeTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_an_instance_of_fractal()
    {
        $this->assertInstanceOf(\Spatie\Fractal\Fractal::class, Fractal::collection([]));
    }
}
