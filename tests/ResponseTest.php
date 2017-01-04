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

    /** @test */
    public function it_sets_a_status_code_provided_as_a_parameter() {
        $response = fractal()
            ->collection(['item', 'item2'])
            ->transformWith(function ($item) {
                return $item.'-transformed';
            })
            ->respond(404);

        $this->assertEquals(404, $response->status());
    }

    /** @test */
    public function it_sets_headers_provided_as_a_parameter() {
        $response = fractal()
            ->collection(['item', 'item2'])
            ->transformWith(function ($item) {
                return $item.'-transformed';
            })
            ->respond(404, ['test' => 'test-value']);

        $this->assertArraySubset(['test' => ['test-value']], $response->headers->all());
    }

    /** @test */
    public function status_code_can_be_provided_in_the_closure() {
        $response = fractal()
            ->collection(['item', 'item2'])
            ->transformWith(function ($item) {
                return $item.'-transformed';
            })
            ->respond(function ($response) {
                $response->code(404);
            });

        $this->assertEquals(404, $response->status());
    }

    /** @test */
    public function headers_can_be_provided_in_the_closure() {
        $response = fractal()
            ->collection(['item', 'item2'])
            ->transformWith(function ($item) {
                return $item.'-transformed';
            })
            ->respond(function ($response) {
                $response->header('test', 'test-value');
            });

        $this->assertArraySubset(['test' => ['test-value']], $response->headers->all());
    }
}
