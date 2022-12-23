<?php

namespace Spatie\Fractal\Test;

use Spatie\Fractal\Test\Classes\TestTransformer;
use Spatie\Fractalistic\ArraySerializer;

trait SetupClosureDefaultSerializerTest {
    protected function getEnvironmentSetUp($app)
    {
        $this->defaultSerializer = ArraySerializer::class;
        parent::getEnvironmentSetUp($app);
    }
}

uses(SetupClosureDefaultSerializerTest::class);

it('uses configured transformer when toarray is used', function () {
    $array = $this->fractal
        ->item($this->testBooks[0])
        ->transformWith(new TestTransformer())
        ->toArray();

    $expectedArray = ['id' => 1, 'author' => 'Philip K Dick'];

    expect($array)->toEqual($expectedArray);
});

it('uses configured transformer when response is used', function () {
    $response = $this->fractal
        ->item($this->testBooks[0])
        ->transformWith(new TestTransformer())
        ->respond();

    expect(json_encode($response->getData()))->toEqual('{"id":1,"author":"Philip K Dick"}');
});
