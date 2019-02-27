<?php

namespace Spatie\Fractal\Test;

use Spatie\Fractalistic\ArraySerializer;

class ClosureDefaultSerializerTest extends TestCase
{
    public function setUp($defaultSerializer = '', $defaultPaginator = ''): void
    {
        parent::setUp(function () {
            return new ArraySerializer();
        });
    }

    /** @test */
    public function it_uses_configured_transformer_when_toarray_is_used()
    {
        $array = $this->fractal
            ->item($this->testBooks[0])
            ->transformWith(new TestTransformer())
            ->toArray();

        $expectedArray = ['id' => 1, 'author' => 'Philip K Dick'];

        $this->assertEquals($expectedArray, $array);
    }

    /** @test */
    public function it_uses_configured_transformer_when_response_is_used()
    {
        $response = $this->fractal
            ->item($this->testBooks[0])
            ->transformWith(new TestTransformer())
            ->respond();

        $this->assertEquals('{"id":1,"author":"Philip K Dick"}', json_encode($response->getData()));
    }
}
