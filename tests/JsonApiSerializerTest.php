<?php

use League\Fractal\Serializer\JsonApiSerializer;

beforeEach(function () {
    app('config')->set('fractal.default_serializer', JsonApiSerializer::class);
});

it('will not generate links when the base url is null', function () {
    app('config')->set('fractal.base_url', null);

    $fractal = fractal()
        ->collection([
        [
            'id' => 1,
            'title' => 'Test 1',
        ],
        [
            'id' => 4,
            'title' => 'Test 2',
        ],
        ])
        ->transformWith(function ($item) {
            return [
                'id' => $item['id'],
                'title' => $item['title'].'-transformed',
            ];
        })
        ->withResourceName('articles')
        ->respond();

    expect($fractal->getData()->data[0])->not->toHaveProperty('links')
        ->and($fractal->getData()->data[1])->not->toHaveProperty('links');
});

it('will generate relative links when json api has empty string base url', function () {
    app('config')->set('fractal.base_url', '');

    $fractal = fractal()
        ->collection([
        [
            'id' => 1,
            'title' => 'Test 1',
        ],
        [
            'id' => 4,
            'title' => 'Test 2',
        ],
        ])
        ->transformWith(function ($item) {
        return [
            'id' => $item['id'],
            'title' => $item['title'].'-transformed',
        ];
        })
        ->withResourceName('articles')
        ->respond();

    expect($fractal->getData()->data[0]->links->self)->toEqual('/articles/1')
        ->and($fractal->getData()->data[1]->links->self)->toEqual('/articles/4');
});

it('will generate fully qualified links when json api has base url', function () {
    app('config')->set('fractal.base_url', 'http://example.com');

    $fractal = fractal()
        ->collection([
        [
            'id' => 1,
            'title' => 'Test 1',
        ],
        [
            'id' => 4,
            'title' => 'Test 2',
        ],
        ])
        ->transformWith(function ($item) {
        return [
            'id' => $item['id'],
            'title' => $item['title'].'-transformed',
        ];
        })
        ->withResourceName('articles')
        ->respond();

    expect($fractal->getData()->data[0]->links->self)->toEqual('http://example.com/articles/1')
        ->and($fractal->getData()->data[1]->links->self)->toEqual('http://example.com/articles/4');
});
