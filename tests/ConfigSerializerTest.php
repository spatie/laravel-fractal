<?php

use Spatie\Fractal\Test\Classes\TestTransformer;
use Spatie\Fractalistic\ArraySerializer;

trait SetupConfigSerializerTest {
    protected function getEnvironmentSetUp($app)
    {
        $this->defaultSerializer = ArraySerializer::class;
        parent::getEnvironmentSetUp($app);
    }
}

uses(SetupConfigSerializerTest::class)->group('group');

it('uses the default transformer when it is specified', function () {
    $array = $this->fractal
        ->item($this->testBooks[0])
        ->transformWith(new TestTransformer())
        ->toArray();

    $expectedArray = ['id' => 1, 'author' => 'Philip K Dick'];

    expect($array)->toEqual($expectedArray);
});
