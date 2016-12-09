<?php

namespace Spatie\Fractal\Test;

use Fractal as FractalFacade;
use Spatie\Fractalistic\Fractal;

class FractalFacadeTest extends TestCase
{
    /** @test */
    public function it_returns_an_instance_of_fractal()
    {
        $this->assertInstanceOf(Fractal::class, FractalFacade::collection([]));
    }
}
