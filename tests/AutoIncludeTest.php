<?php

it('includes can be passed as array', function () {
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
});

it('includes can be passed as string', function () {
    $response = $this->call('GET', '/auto-includes', [
        'include' => 'characters,publisher',
    ]);
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
        ['id', 'author', 'characters', 'publisher'],
        ],
    ]);
});

it('includes are missing when parameter is not passed', function () {
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
