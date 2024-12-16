<?php

use Illuminate\Testing\Fluent\AssertableJson;

it('returns only requested fields', function ($fields, $expectedMissing) {
    config()->set('fractal.auto_fieldsets.enabled', true);
    $response = $this->call('GET', '/auto-fieldsets-with-resource-name', [
        'fields' => [
            'books' => $fields,
        ],
        'include' => 'characters,publisher',
    ]);

    $response->assertOk();
    $response->assertJson(
        fn (AssertableJson $json) => $json->has(
            'data',
            2,
            fn (AssertableJson $json) => $json->hasAll($fields)
            ->missing($expectedMissing),
        ),
    );
})->with([
    ['author', 'id'],
    ['id', 'author'],
    [['author', 'id'], 'publisher'],
    [['id', 'author', 'publisher'], 'characters'],
]);

it('doesnt work if "resource name" is not set', function ($fields) {
    config()->set('fractal.auto_fieldsets.enabled', true);
    $response = $this->call('GET', '/auto-fieldsets-without-resource-name', [
        'fields' => [
            'books' => $fields,
        ],
        'include' => 'characters,publisher',
    ]);

    $response->assertOk();
    $response->assertJson(
        fn (AssertableJson $json) => $json->has(
            'data',
            2,
            fn (AssertableJson $json) => $json->hasAll(['id', 'author', 'characters', 'publisher'])
        ),
    );
})->with([
    ['author', 'id'],
    ['id', 'author'],
    [['author', 'id']],
    [['id', 'author', 'publisher']],
]);

it('all fields are present when parameter is not passed', function () {
    config()->set('fractal.auto_fieldsets.enabled', true);
    $response = $this->call('GET', '/auto-fieldsets-with-resource-name', [
        'include' => 'characters',
    ]);

    $response->assertOk();
    $response->assertJson(
        fn (AssertableJson $json) => $json->has(
            'data',
            2,
            fn (AssertableJson $json) => $json->hasAll(['id', 'author', 'characters'])
            ->missing('publisher'),
        ),
    );
});

it('can be disabled via config', function () {
    config()->set('fractal.auto_fieldsets.enabled', false);

    $response = $this->call('GET', '/auto-fieldsets-with-resource-name', [
        'fields' => [
            'books' => ['author', 'id'],
        ],
        'include' => 'characters,publisher',
    ]);

    $response->assertOk();
    $response->assertJson(
        fn (AssertableJson $json) => $json->has(
            'data',
            2,
            fn (AssertableJson $json) => $json->hasAll(['id', 'author', 'characters', 'publisher'])
        ),
    );
});

it('uses the configured request key', function () {
    config()->set('fractal.auto_fieldsets.enabled', true);
    config()->set('fractal.auto_fieldsets.request_key', 'other_fields');
    $response = $this->call('GET', '/auto-fieldsets-with-resource-name', [
        'fields' => [
            'books' => 'author',
        ],
        'other_fields' => [
            'books' => 'id',
        ],
    ]);

    $response->assertOk();
    $response->assertJson(
        fn (AssertableJson $json) => $json->has(
            'data',
            2,
            fn (AssertableJson $json) => $json->has('id')
            ->missing('author')
        ),
    );
});
