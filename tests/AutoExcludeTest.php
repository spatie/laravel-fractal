<?php

it('excludes can be passed as array', function () {
    $response = $this->call('GET', '/auto-includes', [
        'include' => [
        'characters',
        'publisher',
        ],
        'exclude' => [
        'publisher',
        ],
    ]);
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
        ['id', 'author', 'characters'],
        ],
    ]);
});

it('excludes can be passed as string', function () {
    $response = $this->call('GET', '/auto-includes', [
        'include' => 'characters,publisher',
        'exclude' => 'publisher',
    ]);
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
        ['id', 'author', 'characters'],
        ],
    ]);
});

it('excludes are missing when parameter is not passed', function () {
    $response = $this->call('GET', '/auto-includes');
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
        ['id', 'author'],
        ],
    ]);

    foreach ($response->json()['data'] as $book) {
        expect($book)->not->toHaveKeys(['characters', 'publisher']);
    }
});
