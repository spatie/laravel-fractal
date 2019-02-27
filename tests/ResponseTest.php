<?php

namespace Spatie\Fractal\Test;

use Illuminate\Http\JsonResponse;

class ResponseTest extends TestCase
{
    /** @var \Spatie\Fractal\Fractal */
    protected $fractal;

    public function setUp($defaultSerializer = '', $defaultPaginator = ''): void
    {
        parent::setUp();

        $this->fractal = fractal()
            ->collection(['item', 'item2'])
            ->transformWith(function ($item) {
                return ['item' => $item.'-transformed'];
            });
    }

    /** @test */
    public function it_can_return_a_json_response()
    {
        $response = $this->fractal->respond();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('{"data":[{"item":"item-transformed"},{"item":"item2-transformed"}]}', json_encode($response->getData()));
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_uses_the_given_response_code()
    {
        $response = $this->fractal->respond(404);

        $this->assertEquals(404, $response->status());
    }

    /** @test */
    public function it_uses_the_given_headers()
    {
        $response = $this->fractal
            ->respond(404, [
                'test' => 'test-value',
                'test2' => 'test2-value',
            ]);

        $this->assertArraySubset([
            'test' => ['test-value'],
            'test2' => ['test2-value'],
        ], $response->headers->all());
    }

    /** @test */
    public function it_uses_the_given_encoding_options()
    {
        $response = $this->fractal->respond(200, [], JSON_PRETTY_PRINT);
        $this->assertTrue($response->hasEncodingOption(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_accepts_a_status_code_in_the_given_closure()
    {
        $response = $this->fractal
            ->respond(function (JsonResponse $response) {
                $response->setStatusCode(404);
            });

        $this->assertEquals(404, $response->status());
    }

    /** @test */
    public function it_accepts_a_headers_in_the_given_closure()
    {
        $response = $this->fractal
            ->respond(function (JsonResponse $response) {
                $response->header('test', 'test-value');
                $response->withHeaders(['test2' => 'test2-value']);
            });

        $this->assertArraySubset([
            'test' => ['test-value'],
            'test2' => ['test2-value'],
        ], $response->headers->all());
    }

    /** @test */
    public function it_accepts_encoding_options_in_the_given_closure()
    {
        $response = $this->fractal
            ->respond(function (JsonResponse $response) {
                $response->setEncodingOptions(JSON_PRETTY_PRINT);
            });

        $this->assertTrue($response->hasEncodingOption(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function it_accept_a_response_code_and_a_callback()
    {
        $response = $this->fractal
            ->respond(404, function (JsonResponse $response) {
                $response->header('test', 'test-value');
            });

        $this->assertEquals(404, $response->status());
        $this->assertArraySubset([
            'test' => ['test-value'],
        ], $response->headers->all());
    }

    /** @test */
    public function it_accepts_a_response_code_and_headers_and_a_callback()
    {
        $response = $this->fractal->respond(404, ['test' => 'test-value'], function (JsonResponse $response) {
            $response->setEncodingOptions(JSON_PRETTY_PRINT);
        });

        $this->assertEquals(404, $response->status());
        $this->assertArraySubset([
            'test' => ['test-value'],
        ], $response->headers->all());
        $this->assertTrue($response->hasEncodingOption(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function all_allowed_methods_in_the_callback_are_chainable()
    {
        $response = $this->fractal
            ->respond(function (JsonResponse $response) {
                $response
                    ->header('test', 'test-value')
                    ->setStatusCode(404)
                    ->withHeaders([
                        'test3' => 'test3-value',
                        'test4' => 'test4-value',
                    ])
                    ->header('test2', 'test2-value')
                    ->setEncodingOptions(JSON_PRETTY_PRINT);
            });

        $this->assertArraySubset([
            'test' => ['test-value'],
            'test2' => ['test2-value'],
            'test3' => ['test3-value'],
            'test4' => ['test4-value'],
        ], $response->headers->all());

        $this->assertEquals(404, $response->status());

        $this->assertTrue($response->hasEncodingOption(JSON_PRETTY_PRINT));
    }

    /** @test */
    public function the_status_code_set_in_the_closure_will_be_used_event_when_passing_a_status_code_to_the_respond_method()
    {
        $response = $this->fractal->respond(200, function (JsonResponse $response) {
            $response->setStatusCode(300);
        });

        $this->assertEquals(300, $response->getStatusCode());
    }

    /** @test */
    public function the_encoding_options_set_in_the_closure_will_be_used_when_passing_encoding_options_to_the_respond_method()
    {
        $response = $this->fractal->respond(200, function (JsonResponse $response) {
            $response->setEncodingOptions(JSON_UNESCAPED_SLASHES);
        }, JSON_PRETTY_PRINT);

        $this->assertTrue($response->hasEncodingOption(JSON_UNESCAPED_SLASHES));
        $this->assertFalse($response->hasEncodingOption(JSON_PRETTY_PRINT));
    }
}
