<?php

namespace Spatie\Fractal\Test\Integration;

class MetaTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_add_meta()
    {
        $array = $this->fractal
            ->collection($this->testBooks, new TestTransformer())
            ->parseIncludes('characters')
            ->meta(['key' => 'value'])
            ->toArray();

        $expectedArray = ['data' => [
            ['id' => 1, 'author' => 'Philip K Dick',  'characters' => ['data' => ['Death', 'Hex']]],
            ['id' => 2, 'author' => 'George R. R. Satan', 'characters' => ['data' => ['Ned Stark', 'Tywin Lannister']]],
        ],
        'meta' => ['key' => 'value']];

        $this->assertEquals($expectedArray, $array);
    }
}
