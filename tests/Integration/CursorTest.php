<?php

namespace Spatie\Fractal\Test\Integration;

use League\Fractal\Pagination\Cursor;
use League\Fractal\Serializer\JsonApiSerializer;

class CursorTest extends TestCase
{
    /**
     * @test
     */
    public function it_gerenates_data_with_cursor()
    {
        $books = [$this->testBooks[0]];

        $currentCursor = 0;
        $previousCursor = null;
        $count = count($books);
        $newCursor = $currentCursor + $count;

        $array = $this->fractal
            ->collection($books, new TestTransformer())
            ->serializeWith(new JsonApiSerializer())
            ->withCursor(new Cursor($currentCursor, $previousCursor, $newCursor, $count))
            ->toArray();

        $expectedArray = [
            'data' => [
                [
                    'id' => 1,
                    'type' => null,
                    'attributes' => [
                        'author' => 'Philip K Dick',
                    ],
                ],
            ],
            'meta' => [
                'cursor' => [
                    'prev' => $previousCursor,
                    'current' => $currentCursor,
                    'next' => $newCursor,
                    'count' => $count,

                ],
            ],
        ];

        $this->assertEquals($expectedArray, $array);
    }
}
