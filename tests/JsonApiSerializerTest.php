<?php

namespace Spatie\Fractal\Test;

use League\Fractal\Serializer\JsonApiSerializer;

class JsonApiSerializerTest extends TestCase
{
    public function setUp($defaultSerializer = '')
    {
        parent::setUp();

        app('config')->set('laravel-fractal.default_serializer', JsonApiSerializer::class);
    }

    /** @test */
    public function it_can_has_links_when_json_api_has_base_url_on_instantiate()
    {
        app('config')->set('laravel-fractal.base_url', 'http://example.com');

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
                    'title' => $item['title'] . '-transformed',
                ];
            })
            ->withResourceName('articles')
            ->respond();

        $this->assertEquals('http://example.com/articles/1', $fractal->getData()->data[0]->links->self);
        $this->assertEquals('http://example.com/articles/4', $fractal->getData()->data[1]->links->self);
    }
}
