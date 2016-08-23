<?php

namespace Spatie\Fractal\Test\Integration;

use League\Fractal\Serializer\JsonApiSerializer;

class DefaultSerializerObjectTest extends TestCase
{
    public function setUp($defaultSerializer = '')
    {
        parent::setUp(new JsonApiSerializer());
    }

    /**
     * @test
     */
    public function it_can_use_an_instantiated_serializer_as_a_default()
    {
        $array = $this->fractal
            ->collection($this->testBooks, new TestTransformer(), 'books')
            ->toArray();

        $expectedArray = [
            'data' => [
                [
                    'id' => 1,
                    'type' => 'books',
                    'attributes' => [
                        'author' => 'Philip K Dick',
                    ],
                ],
                [
                    'id' => 2,
                    'type' => 'books',
                    'attributes' => [
                        'author' => 'George R. R. Satan',
                    ],
                ],
            ],
        ];

        $this->assertEquals($expectedArray, $array);
    }
}
