<?php

namespace Spatie\Fractal\Test\Integration;

use League\Fractal\Serializer\JsonApiSerializer;

class ResourceNameTest extends TestCase
{
    /**
     * @test
     */
    public function it_uses_a_custom_resource_name_when_creating_a_collection()
    {
        $array = $this->fractal
            ->collection($this->testBooks, new TestTransformer(), 'books')
            ->serializeWith(new JsonApiSerializer())
            ->toArray();

        $expectedArray = [
            'books' => [
                ['id' => 1, 'author' => 'Philip K Dick'],
                ['id' => 2, 'author' => 'George R. R. Satan'],
            ],
        ];

        $this->assertEquals($expectedArray, $array);
    }

    /**
     * @test
     */
    public function it_uses_a_custom_resource_name_when_using_setter()
    {
        $array = $this->fractal
            ->collection($this->testBooks, new TestTransformer())
            ->resourceName('books')
            ->serializeWith(new JsonApiSerializer())
            ->toArray();

        $expectedArray = [
            'books' => [
                ['id' => 1, 'author' => 'Philip K Dick'],
                ['id' => 2, 'author' => 'George R. R. Satan'],
            ],
        ];

        $this->assertEquals($expectedArray, $array);
    }

    /**
     * @test
     */
    public function it_uses_a_custom_resource_name_for_an_item()
    {
        $array = $this->fractal
            ->item($this->testBooks[0], new TestTransformer())
            ->resourceName('book')
            ->serializeWith(new JsonApiSerializer())
            ->toArray();

        $expectedArray = [
            'book' => [
                ['id' => 1, 'author' => 'Philip K Dick'],
            ],
        ];

        $this->assertEquals($expectedArray, $array);
    }

    /**
     * @test
     */
    public function it_uses_data_as_resource_name_when_not_set()
    {
        $array = $this->fractal
            ->collection($this->testBooks, new TestTransformer())
            ->serializeWith(new JsonApiSerializer())
            ->toArray();

        $expectedArray = [
            'data' => [
                ['id' => 1, 'author' => 'Philip K Dick'],
                ['id' => 2, 'author' => 'George R. R. Satan'],
            ],
        ];

        $this->assertEquals($expectedArray, $array);
    }
}
