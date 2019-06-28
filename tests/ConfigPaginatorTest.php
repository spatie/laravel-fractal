<?php

namespace Spatie\Fractal\Test;

use Illuminate\Pagination\LengthAwarePaginator;

class ConfigPaginatorTest extends TestCase
{
    public function setUp($defaultSerializer = '', $defaultPaginator = ''): void
    {
        parent::setUp('', TestPaginator::class);
    }

    /** @test */
    public function it_uses_the_default_paginator_when_it_is_specified()
    {
        $paginator = new LengthAwarePaginator(
            $this->testBooks,
            count($this->testBooks),
            1
        );

        $array = fractal(
            $paginator,
            new TestTransformer()
        )->toArray();

        $expectedArray = [
            'data' => [
                ['id' => 1, 'author' => 'Philip K Dick'],
                ['id' => 2, 'author' => 'George R. R. Satan'],
            ],
            'meta' => [
                'pagination' => [
                    'total' => 9999,
                    'count' => 2,
                    'per_page' => 1,
                    'current_page' => 1,
                    'total_pages' => 2,
                    'links' => [
                        'next' => '/?page=2',
                    ],
                ],
            ],
        ];

        $this->assertEquals($expectedArray, $array);
    }
}
