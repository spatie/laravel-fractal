<?php

namespace Spatie\Fractal\Test;

use Spatie\Fractal\Fractal;
use Illuminate\Http\JsonResponse;

class ResponseTest extends TestCase
{
    /** Set-up a new Fractal instance using fractal() helper method */
    public function fractal()
    {
        return fractal()
            ->collection(['item', 'item2'])
            ->transformWith(function ($item) {
                return $item.'-transformed';
            });
    }

    /** @test */
    public function it_makes_a_json_response()
    {
        $response = $this->fractal()->respond();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('{"data":["item-transformed","item2-transformed"]}', json_encode($response->getData()));
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_sets_a_status_code_provided_as_a_parameter()
    {
        $response = $this->fractal()->respond(404);

        $this->assertEquals(404, $response->status());
    }

    /** @test */
    public function it_sets_headers_provided_as_a_parameter()
    {
        $response = $this->fractal()
            ->respond(404, ['test' => 'test-value', 'test2' => 'test2-value']);

        $this->assertArraySubset([
            'test' => ['test-value'],
            'test2' => ['test2-value'],
        ], $response->headers->all());
    }

    /** @test */
    public function status_code_can_be_provided_in_the_closure()
    {
        $response = $this->fractal()
            ->respond(function ($response) {
                $response->code(404);
            });

        $this->assertEquals(404, $response->status());
    }

    /** @test */
    public function headers_can_be_provided_in_the_closure()
    {
        $response = $this->fractal()
            ->respond(function ($response) {
                $response->header('test', 'test-value');
                $response->headers(['test2' => 'test2-value']);
            });

        $this->assertArraySubset([
            'test' => ['test-value'],
            'test2' => ['test2-value'],
        ], $response->headers->all());
    }

    /** @test */
    public function the_code_can_be_allowed_along_with_the_callback()
    {
        $response = $this->fractal()
            ->respond(404, function ($response) {
                $response->header('test', 'test-value');
            });

        $this->assertEquals(404, $response->status());
        $this->assertArraySubset([
            'test' => ['test-value'],
        ], $response->headers->all());
    }

    /** @test */
    public function callback_allows_chaining()
    {
        $response = $this->fractal()
            ->respond(function ($response) {
                $response
                    ->header('test', 'test-value')
                    ->code(404)
                    ->headers([
                        'test3' => 'test3-value',
                        'test4' => 'test4-value',
                    ])
                    ->header('test2', 'test2-value');
            });

        $this->assertArraySubset([
            'test' => ['test-value'],
            'test2' => ['test2-value'],
            'test3' => ['test3-value'],
            'test4' => ['test4-value'],
        ], $response->headers->all());

        $this->assertEquals(404, $response->status());
    }
}
