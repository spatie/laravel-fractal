<?php

use League\Fractal\Serializer\DataArraySerializer;
use Spatie\Fractal\Facades\Fractal;
use Spatie\Fractal\Test\Classes\TestTransformer;
use Spatie\Fractalistic\ArraySerializer;
use Spatie\Fractalistic\Fractal as FractalClass;

it('returns an instance of fractal', function () {
    expect(Fractal::collection([]))->toBeInstanceOf(FractalClass::class);
});

it('can transform the given array with the given closure', function () {
    $transformedData = Fractal::collection(['item1', 'item2'], function ($item) {
        return ['item' => $item.'-transformed'];
    })->toArray();

    expect($transformedData)->toEqual([
        'data' => [['item' => 'item1-transformed'], ['item' => 'item2-transformed']],
    ]);
});

it('will use the configured serializer', function () {
    $this->app['config']->set('fractal.default_serializer', ArraySerializer::class);

    $response = Fractal::create()
        ->item($this->testBooks[0])
        ->transformWith(new TestTransformer())
        ->respond(200);

    expect(json_encode($response->getData()))->toEqual('{"id":1,"author":"Philip K Dick"}');
});

it('will use the provided serializer instead of the configured serializer', function () {
    $this->app['config']->set('fractal.default_serializer', DataArraySerializer::class);

    $actualArray = Fractal::create($this->testBooks, new TestTransformer(), new ArraySerializer())->toArray();

    $expectedArray = [
        ['id' => 1, 'author' => 'Philip K Dick'],
        ['id' => 2, 'author' => 'George R. R. Satan'],
    ];

    expect($actualArray)->toEqual($expectedArray);
});
