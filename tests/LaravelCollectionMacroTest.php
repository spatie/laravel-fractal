<?php

use Illuminate\Support\Collection;
use Spatie\Fractal\Test\Classes\TestTransformer;

it('provides laravel collection macro', function () {
    $transformedData = Collection::make($this->testBooks)
        ->transformWith(new TestTransformer())
        ->toArray();

    $expectedArray = ['data' => [
        ['id' => 1, 'author' => 'Philip K Dick'],
        ['id' => 2, 'author' => 'George R. R. Satan'],
    ]];

    expect($transformedData)->toEqual($expectedArray);
});
