<?php

namespace Spatie\Fractal\Test;

use Fractal as FractalFacade;
use Spatie\Fractalistic\ArraySerializer;

class ConfigTest extends TestCase
{
    public function setUp($defaultSerializer = '')
    {
        parent::setup(ArraySerializer::class);
    }

    /** @test */
    public function it_uses_the_default_transformer_when_it_is_specified()
    {
        $array = $this->fractal
            ->item($this->testBooks[0])
            ->transformWith(new TestTransformer())
            ->toArray();

        $expectedArray = ['id' => 1, 'author' => 'Philip K Dick'];

        $this->assertEquals($expectedArray, $array);
    }

    /** @test */
    public function user_config_is_used_when_responding_using_facade()
    {
        $response = FractalFacade::create()
            ->item($this->testBooks[0])
            ->transformWith(new TestTransformer())
            ->respond(200);

        $this->assertEquals('{"id":1,"author":"Philip K Dick"}', json_encode($response->getData()));
    }
}
