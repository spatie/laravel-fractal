<?php

namespace Spatie\Fractal\Test;

use Spatie\Fractalistic\ArraySerializer;

class ClosureDefaultSerializerTest extends TestCase
{

    public function setUp($defaultSerializer = '')
    {
        parent::setup(function() {
            return new ArraySerializer();
        });
    }

    /** @test */
    public function it_uses_the_default_transformer_when_it_is_specified()
    {
        $array = $this->fractal
            ->item($this->testBooks[0])
            ->transformWith(new TestTransformer())
            ->toArray();

        $expectedArray = ['id' => 1, 'author' => 'Philip K Dick'];

        $this->assertEquals($expectedArray, $array);
    }

}
