<?php

namespace Spatie\Fractal\Test\Integration;

use Spatie\Fractal\Fractal;

class FractalHelperTest extends TestCase
{
    /**
     * @test
     */
    public function it_return_an_instance_of_fractal()
    {
        $this->assertInstanceOf(Fractal::class, fractal());
    }
}
