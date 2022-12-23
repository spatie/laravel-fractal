<?php

use Illuminate\Http\JsonResponse;

beforeEach(function () {
    $this->fractal = fractal()
        ->collection(['item', 'item2'])
        ->transformWith(function ($item) {
            return ['item' => $item.'-transformed'];
        });
});

it('can return a json response', function () {
    $response = $this->fractal->respond();

    expect($response)->toBeInstanceOf(JsonResponse::class)
        ->and(json_encode($response->getData()))->toEqual('{"data":[{"item":"item-transformed"},{"item":"item2-transformed"}]}')
        ->and($response->status())->toEqual(200);
});

it('uses the given response code', function () {
    $response = $this->fractal->respond(404);

    expect($response->status())->toEqual(404);
});

it('uses the given headers', function () {
    $response = $this->fractal
        ->respond(404, [
        'test' => 'test-value',
        'test2' => 'test2-value',
        ]);

    $headers = $response->headers->all();

    expect($headers['test'])->toEqual(['test-value'])
        ->and($headers['test2'])->toEqual(['test2-value']);
});

it('uses the given encoding options', function () {
    $response = $this->fractal->respond(200, [], JSON_PRETTY_PRINT);
    expect($response->hasEncodingOption(JSON_PRETTY_PRINT))->toBeTrue();
});

it('accepts a status code in the given closure', function () {
    $response = $this->fractal
        ->respond(function (JsonResponse $response) {
            $response->setStatusCode(404);
        });

    expect($response->status())->toEqual(404);
});

it('accepts a headers in the given closure', function () {
    $response = $this->fractal
        ->respond(function (JsonResponse $response) {
            $response->header('test', 'test-value');
            $response->withHeaders(['test2' => 'test2-value']);
        });

    expect($response->headers->all()['test'])->toEqual(['test-value'])
        ->and($response->headers->all()['test2'])->toEqual(['test2-value']);
});

it('accepts encoding options in the given closure', function () {
    $response = $this->fractal
        ->respond(function (JsonResponse $response) {
            $response->setEncodingOptions(JSON_PRETTY_PRINT);
        });

    expect($response->hasEncodingOption(JSON_PRETTY_PRINT))->toBeTrue();
});

it('accept a response code and a callback', function () {
    $response = $this->fractal
        ->respond(404, function (JsonResponse $response) {
            $response->header('test', 'test-value');
        });

    expect($response->status())->toEqual(404)
        ->and($response->headers->all()['test'])->toEqual(['test-value']);
});

it('accepts a response code and headers and a callback', function () {
    $response = $this->fractal->respond(404, ['test' => 'test-value'], function (JsonResponse $response) {
        $response->setEncodingOptions(JSON_PRETTY_PRINT);
    });

    expect($response->status())->toEqual(404)
        ->and($response->headers->all()['test'])->toEqual(['test-value'])
        ->and($response->hasEncodingOption(JSON_PRETTY_PRINT))->toBeTrue();
});

it('all allowed methods in the callback are chainable', function () {
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

    expect($response->status())->toEqual(404)
        ->and($response->hasEncodingOption(JSON_PRETTY_PRINT))->toBeTrue();
});

it('the status code set in the closure will be used event when passing a status code to the respond method', function () {
    $response = $this->fractal->respond(200, function (JsonResponse $response) {
        $response->setStatusCode(300);
    });

    expect($response->getStatusCode())->toEqual(300);
});

it('the encoding options set in the closure will be used when passing encoding options to the respond method', function () {
    $response = $this->fractal->respond(200, function (JsonResponse $response) {
        $response->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }, JSON_PRETTY_PRINT);

    expect($response->hasEncodingOption(JSON_UNESCAPED_SLASHES))->toBeTrue()
        ->and($response->hasEncodingOption(JSON_PRETTY_PRINT))->toBeFalse();
});
