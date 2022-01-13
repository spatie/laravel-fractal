<?php

namespace Spatie\Fractal\Test;

use League\Fractal\Serializer\DataArraySerializer;
use Spatie\Fractal\Facades\Fractal;
use Spatie\Fractalistic\ArraySerializer;
use Spatie\Fractalistic\Fractal as FractalClass;

class FractalFacadeTest extends TestCase
{
    /** @test */
    public function it_returns_an_instance_of_fractal()
    {
        $this->assertInstanceOf(FractalClass::class, Fractal::collection([]));
    }

    /** @test */
    public function it_can_transform_the_given_array_with_the_given_closure()
    {
        $transformedData = Fractal::collection(['item1', 'item2'], function ($item) {
            return ['item' => $item.'-transformed'];
        })->toArray();

        $this->assertEquals([
            'data' => [['item' => 'item1-transformed'], ['item' => 'item2-transformed']],
        ], $transformedData);
    }

    /** @test */
    public function it_will_use_the_configured_serializer()
    {
        $this->app['config']->set('fractal.default_serializer', ArraySerializer::class);

        $response = Fractal::create()
            ->item($this->testBooks[0])
            ->transformWith(new TestTransformer())
            ->respond(200);

        $this->assertEquals('{"id":1,"author":"Philip K Dick"}', json_encode($response->getData()));
    }

    /** @test */
    public function it_will_use_the_provided_serializer_instead_of_the_configured_serializer()
    {
        $this->app['config']->set('fractal.default_serializer', DataArraySerializer::class);

        $actualArray = Fractal::create($this->testBooks, new TestTransformer(), new ArraySerializer())->toArray();

        $expectedArray = [
            ['id' => 1, 'author' => 'Philip K Dick'],
            ['id' => 2, 'author' => 'George R. R. Satan'],
        ];

        $this->assertEquals($expectedArray, $actualArray);
    }
}
