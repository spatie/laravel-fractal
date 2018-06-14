<?php

namespace Spatie\Fractal\Test;

class AutoIncludeTest extends TestCase
{
    /** @test */
    public function includes_can_be_passed_as_array()
    {
        $response = $this->call('GET', '/auto-includes', [
            'include' => [
                'characters',
                'publisher',
            ],
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                ['id', 'author', 'characters', 'publisher'],
            ],
        ]);
    }

    /** @test */
    public function includes_can_be_passed_as_string()
    {
        $response = $this->call('GET', '/auto-includes', [
            'include' => 'characters,publisher',
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                ['id', 'author', 'characters', 'publisher'],
            ],
        ]);
    }

    /** @test */
    public function includes_are_missing_when_parameter_is_not_passed()
    {
        $response = $this->call('GET', '/auto-includes');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                ['id', 'author'],
            ],
        ]);

        foreach ($response->json()['data'] as $book) {
            $this->assertArrayNotHasKey('characters', $book);
            $this->assertArrayNotHasKey('publisher', $book);
        }
    }
}
