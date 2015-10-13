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
            ->addMeta(['key' => 'value'])
            ->toArray();

        $expectedArray = ['data' => [
            ['id' => 1, 'author' => 'Philip K Dick'],
            ['id' => 2, 'author' => 'George R. R. Satan'],
        ],
        'meta' => ['key' => 'value']];

        $this->assertEquals($expectedArray, $array);
    }

    /**
     * @test
     */
    public function it_can_handle_multiple_meta()
    {
        $array = $this->fractal
            ->collection($this->testBooks, new TestTransformer())
            ->addMeta(['key1' => 'value1'])
            ->addMeta(['key2' => 'value2'])
            ->toArray();

        $expectedArray = ['data' => [
            ['id' => 1, 'author' => 'Philip K Dick'],
            ['id' => 2, 'author' => 'George R. R. Satan'],
        ],
        'meta' => ['key1' => 'value1', 'key2' => 'value2']];

        $this->assertEquals($expectedArray, $array);
    }
}
