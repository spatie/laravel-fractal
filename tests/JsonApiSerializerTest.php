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
    public function it_cannot_has_links_when_json_api_base_url_is_null_on_instantiate()
    {
        app('config')->set('laravel-fractal.base_url', null);

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

        $this->assertObjectNotHasAttribute('links', $fractal->getData()->data[0]);
        $this->assertObjectNotHasAttribute('links', $fractal->getData()->data[1]);
    }

    /** @test */
    public function it_can_has_relative_links_when_json_api_has_empty_string_base_url_on_instantiate()
    {
        app('config')->set('laravel-fractal.base_url', '');

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

        $this->assertEquals('/articles/1', $fractal->getData()->data[0]->links->self);
        $this->assertEquals('/articles/4', $fractal->getData()->data[1]->links->self);
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
                    'title' => $item['title'].'-transformed',
                ];
            })
            ->withResourceName('articles')
            ->respond();

        $this->assertEquals('http://example.com/articles/1', $fractal->getData()->data[0]->links->self);
        $this->assertEquals('http://example.com/articles/4', $fractal->getData()->data[1]->links->self);
    }
}
