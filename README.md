# An easy to use Fractal wrapper built for Laravel applications

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-fractal.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-fractal)
[![Build Status](https://travis-ci.org/spatie/laravel-fractal.svg?branch=master)](https://travis-ci.org/spatie/laravel-fractal)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-fractal.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-fractal)
[![StyleCI](https://styleci.io/repos/43743138/shield?branch=master)](https://styleci.io/repos/43743138)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-fractal.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-fractal)

The package provides a nice and easy wrapper around [Fractal](http://fractal.thephpleague.com/)
for use in your Laravel applications. If you don't know what Fractal does, [take a peek at their intro](http://fractal.thephpleague.com/).
Shortly said, Fractal is very useful to transform data before using it in an API.

Using Fractal data can be transformed like this:

```php
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

$books = [
   ['id'=>1, 'title'=>'Hogfather', 'characters' => [...]],
   ['id'=>2, 'title'=>'Game Of Kill Everyone', 'characters' => [...]]
];

$manager = new Manager();

$resource = new Collection($books, new BookTransformer());

$manager->parseIncludes('characters');

$manager->createData($resource)->toArray();
```

This package makes that process a tad easier:

```php
fractal()
   ->collection($books)
   ->transformWith(new BookTransformer())
   ->includeCharacters()
   ->toArray();
```

Lovers of facades will be glad to know that a facade is provided:
```php
Fractal::collection($books)->transformWith(new BookTransformer())->toArray();
```

There's also a very short syntax available to quickly transform data:

```php
fractal($books, new BookTransformer())->toArray();
```

You can transform directly from a Laravel collection as well:

```php
collect($books)->transformWith(new BookTransformer());
```

Transforming right from a Laravel collection is particularly useful for Eloquent results:

```php
Users::all()->transformWith(new UserTransformer())->toArray();
```

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all
our open source projects [on our website](https://spatie.be/opensource).

## Installation in Laravel 5.4


You can pull in the package via composer:
```bash
composer require spatie/laravel-fractal:^4.0
```

And then follow [the installation instructions of the v4 branch of this package](https://github.com/spatie/laravel-fractal/tree/4.5.0#install).

## Installation in Laravel 5.5 and up

You can pull in the package via composer:
``` bash
composer require spatie/laravel-fractal
```

The package will automatically register itself.

If you want to [change the default serializer](https://github.com/spatie/fractalistic#changing-the-default-serializer),
the [default paginator](https://github.com/spatie/fractalistic#using-pagination),
or the default fractal class `Spatie\Fractal\Fractal`
you must publish the config file:

```bash
php artisan vendor:publish --provider="Spatie\Fractal\FractalServiceProvider"
```

> If you're upgrading to Laravel 5.5, the existing config file should be renamed from _laravel-fractal.php_ to _fractal.php_

This is the contents of the published file:

```php
return [
     /*
     * The default serializer to be used when performing a transformation. It
     * may be left empty to use Fractal's default one. This can either be a
     * string or a League\Fractal\Serializer\SerializerAbstract subclass.
     */
    'default_serializer' => '',

    /* The default paginator to be used when performing a transformation. It
     * may be left empty to use Fractal's default one. This can either be a
     * string or a League\Fractal\Paginator\PaginatorInterface subclass.*/
    'default_paginator' => '',

    /*
     * League\Fractal\Serializer\JsonApiSerializer will use this value to
     * as a prefix for generated links. Set to `null` to disable this.
     */
    'base_url' => null,

    /*
     * If you wish to override or extend the default Spatie\Fractal\Fractal
     * instance provide the name of the class you want to use.
     */
    'fractal_class' => Spatie\Fractal\Fractal::class,

    'auto_includes' => [

        /*
         * If enabled Fractal will automatically add the includes who's
         * names are present in the `include` request parameter.
         */
        'enabled' => true,

        /*
         * The name of key in the request to where we should look for the includes to include.
         */
        'request_key' => 'include',
    ],
```

## Usage

Refer to [the documentation of `spatie/fractalistic`](https://github.com/spatie/fractalistic) to learn all the methods this package provides.

In all code examples you may use `fractal()` instead of `Fractal::create()`.

## Send a response with transformed data

To return a response with json data you can do this in a Laravel app.

```php
$books = fractal($books, new BookTransformer())->toArray();

return response()->json($books);
```

The `respond()` method on the Fractal class can make this process a bit more streamlined.

```php
return fractal($books, new BookTransformer())->respond();
```

You can pass a response code as the first parameter and optionally some headers as the second

```php
return fractal($books, new BookTransformer())->respond(403, [
    'a-header' => 'a value',
    'another-header' => 'another value',
]);
```

You can pass json encoding options as the third parameter:

```php
return fractal($books, new BookTransformer())->respond(200, [], JSON_PRETTY_PRINT);
```

You can also set the status code and the headers using a callback:

```php
use Illuminate\Http\JsonResponse;

return fractal($books, new BookTransformer())->respond(function(JsonResponse $response) {
    $response
        ->setStatusCode(403)
        ->header('a-header', 'a value')
        ->withHeaders([
            'another-header' => 'another value',
            'yet-another-header' => 'yet another value',
        ]);
});
```

## Quickly creating a transformer

You can run the `make:transformer` command to quickly generate a dummy transformer. By default it will be stored in the `app\Transformers` directory.

## Upgrading

## From v4 to v5

Rename your config file from `laravel-fractal` to `fractal`

### From v2 to v3

`v3` was introduced to swap out the `league/fractal` with `spatie/fractalistic`. Support for Lumen was dropped. You should be able to upgrade a Laravel application from `v2` to `v3` without any code changes.
### From v1 to v2

In most cases you can just upgrade to `v2` with making none or only minor changes to your code:

- `resourceName` has been renamed to `withResourceName`.

The main reason why `v2` of this package was tagged is because v0.14 of the underlying [Fractal](http://fractal.thephpleague.com/) by the League contains breaking change. If you use the `League\Fractal\Serializer\JsonApiSerializer` in v2 the `links` key will contain `self`, `first`, `next` and `last`.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Freek Van der Herten](https://twitter.com/freekmurze)
- [All contributors](../../contributors)

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie).
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
