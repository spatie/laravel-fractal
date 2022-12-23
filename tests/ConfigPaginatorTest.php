<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Fractal\Test\Classes\TestPaginator;
use Spatie\Fractal\Test\Classes\TestTransformer;

trait SetupConfigPaginatorTest
{
    protected function getEnvironmentSetUp($app)
    {
        $this->defaultPaginator = TestPaginator::class;
        parent::getEnvironmentSetUp($app);
    }
}

uses(SetupConfigPaginatorTest::class);

it('uses the default paginator when it is specified', function () {
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

    expect($array)->toEqual($expectedArray);
});
