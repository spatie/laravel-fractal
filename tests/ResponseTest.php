<?php

namespace Spatie\Fractal\Test;

use Illuminate\Http\JsonResponse;
use Spatie\Fractal\Fractal;

class ResponseTest extends TestCase
{
    /** @test */
    public function it_makes_a_json_response() {
        $response = fractal()
            ->collection(['item', 'item2'])
            ->transformWith(function ($item) {
                return $item.'-transformed';
            })
            ->respond();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('{"data":["item-transformed","item2-transformed"]}', json_encode($response->getData()));
    }
}
