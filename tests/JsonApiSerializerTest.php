<?php

namespace Spatie\Fractal\Test;

use League\Fractal\Serializer\JsonApiSerializer;

class JsonApiSerializerTest extends TestCase
{
    public function setUp($defaultSerializer = '', $defaultPaginator = ''): void
    {
        parent::setUp();

        app('config')->set('fractal.default_serializer', JsonApiSerializer::class);
    }

    /** @test */
    public function it_will_not_generate_links_when_the_base_url_is_null()
    {
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

        $this->assertObjectNotHasAttribute('links', $fractal->getData()->data[0]);
        $this->assertObjectNotHasAttribute('links', $fractal->getData()->data[1]);
    }

    /** @test */
    public function it_will_generate_relative_links_when_json_api_has_empty_string_base_url()
    {
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

        $this->assertEquals('/articles/1', $fractal->getData()->data[0]->links->self);
        $this->assertEquals('/articles/4', $fractal->getData()->data[1]->links->self);
    }

    /** @test */
    public function it_will_generate_fully_qualified_links_when_json_api_has_base_url()
    {
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

        $this->assertEquals('http://example.com/articles/1', $fractal->getData()->data[0]->links->self);
        $this->assertEquals('http://example.com/articles/4', $fractal->getData()->data[1]->links->self);
    }
}
