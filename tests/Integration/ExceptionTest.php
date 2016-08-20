<?php

namespace Spatie\Fractal\Test\Integration;

use Spatie\Fractal\Exceptions\NoTransformerSpecified;

class ExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function it_throws_an_exception_if_item_or_collection_was_not_called()
    {
        $this->setExpectedException(NoTransformerSpecified::class);

        $this->fractal->toJson();
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_no_transformer_was_specified()
    {
        $this->setExpectedException(NoTransformerSpecified::class);

        $this->fractal->collection($this->testBooks)->toJson();
    }
}
