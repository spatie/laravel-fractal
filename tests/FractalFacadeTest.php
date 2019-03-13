<?php

namespace Spatie\Fractal\Test;

use Fractal as FractalFacade;
use Spatie\Fractalistic\Fractal;
use Spatie\Fractalistic\ArraySerializer;
use League\Fractal\Serializer\DataArraySerializer;

class FractalFacadeTest extends TestCase
{
    /** @test */
    public function it_returns_an_instance_of_fractal()
    {
        $this->assertInstanceOf(Fractal::class, FractalFacade::collection([]));
        $this->assertInstanceOf(Fractal::class, \Spatie\Fractal\Facades\Fractal::collection([]));
    }

    /** @test */
    public function it_can_transform_the_given_array_with_the_given_closure()
    {
        $transformedData = FractalFacade::collection(['item1', 'item2'], function ($item) {
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

        $response = FractalFacade::create()
            ->item($this->testBooks[0])
            ->transformWith(new TestTransformer())
            ->respond(200);

        $this->assertEquals('{"id":1,"author":"Philip K Dick"}', json_encode($response->getData()));
    }

    /** @test */
    public function it_will_use_the_provided_serializer_instead_of_the_configured_serializer()
    {
        $this->app['config']->set('fractal.default_serializer', DataArraySerializer::class);

        $actualArray = FractalFacade::create($this->testBooks, new TestTransformer, new ArraySerializer)->toArray();

        $expectedArray = [
            ['id' => 1, 'author' => 'Philip K Dick'],
            ['id' => 2, 'author' => 'George R. R. Satan'],
        ];

        $this->assertEquals($expectedArray, $actualArray);
    }
}
