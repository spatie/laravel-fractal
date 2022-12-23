<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Fractal\Test\Classes\TestTransformer;
use Spatie\Fractalistic\ArraySerializer;
use Spatie\Fractalistic\Fractal;

it('returns an instance of fractal when passing no arguments', function () {
    expect(fractal())->toBeInstanceOf(Fractal::class);
});

it('can transform the given array with the given closure', function () {
    $transformedData = fractal(['item1', 'item2'], function ($item) {
        return ['item' => $item.'-transformed'];
    })->toArray();

    expect([
        'data' => [['item' => 'item1-transformed'], ['item' => 'item2-transformed']],
    ])->toEqual($transformedData);
});

it('can transform the given item with the given closure', function () {
    $item = new \stdClass();
    $item->name = 'item1';

    $transformedData = fractal($item, function ($item) {
        return ["{$item->name}-transformed"];
    })->toArray();

    expect([
        'data' => ['item1-transformed'],
    ])->toEqual($transformedData);
});

it('can transform the given array with the given transformer', function () {
    $transformedData = fractal($this->testBooks, new TestTransformer())->toArray();

    $expectedArray = ['data' => [
        ['id' => 1, 'author' => 'Philip K Dick'],
        ['id' => 2, 'author' => 'George R. R. Satan'],
    ]];

    expect($transformedData)->toEqual($expectedArray);
});

it('can transform the given empty array with the given transformer', function () {
    $transformedData = fractal([], new TestTransformer())->toArray();

    $expectedArray = ['data' => []];

    expect($transformedData)->toEqual($expectedArray);
});

it('perform a transformation with the given serializer', function () {
    $transformedData = fractal(
        $this->testBooks,
        new TestTransformer(),
        new ArraySerializer()
    )->toArray();

    $expectedArray = [
        ['id' => 1, 'author' => 'Philip K Dick'],
        ['id' => 2, 'author' => 'George R. R. Satan'],
    ];

    expect($transformedData)->toEqual($expectedArray);
});

it('perform a transformation with the given paginator', function () {
    $paginator = new LengthAwarePaginator(
        $this->testBooks,
        count($this->testBooks),
        1
    );

    $transformedData = fractal(
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
            'total' => 2,
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

    expect($transformedData)->toEqual($expectedArray);
});
