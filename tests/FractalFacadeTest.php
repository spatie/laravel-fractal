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
}
