<?php

namespace Spatie\Fractal\Test\Integration;

use Spatie\Fractal\ArraySerializer;

class SerializerTest extends TestCase
{
    /** @test */
    public function it_does_not_generate_a_data_key_for_a_collection()
    {
        $array = $this->fractal
            ->collection($this->testBooks, new TestTransformer())
            ->serializeWith(new ArraySerializer())
            ->toArray();

        $expectedArray = [
            ['id' => 1, 'author' => 'Philip K Dick'],
            ['id' => 2, 'author' => 'George R. R. Satan'],
        ];

        $this->assertEquals($expectedArray, $array);
    }

    /** @test */
    public function it_does_not_generate_a_data_key_for_an_item()
    {
        $array = $this->fractal
            ->item($this->testBooks[0], new TestTransformer())
            ->serializeWith(new ArraySerializer())
            ->toArray();

        $expectedArray = ['id' => 1, 'author' => 'Philip K Dick'];

        $this->assertEquals($expectedArray, $array);
    }
}
