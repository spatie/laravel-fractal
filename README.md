# A Fractal service provider for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-fractal.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-fractal)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://travis-ci.org/spatie/laravel-fractal.svg?branch=master)](https://travis-ci.org/spatie/laravel-fractal)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-fractal.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-fractal)
[![StyleCI](https://styleci.io/repos/43743138/shield?branch=master)](https://styleci.io/repos/43743138)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-fractal.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-fractal)

The package provides a nice and easy integration with [Fractal](http://fractal.thephpleague.com/)
for your Laravel applications. If you don't know what Fractal does, [take a peek at their intro](http://fractal.thephpleague.com/).
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

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all
our open source projects [on our website](https://spatie.be/opensource).

## Postcardware

You're free to use this package (it's [MIT-licensed](LICENSE.md)), but if it makes it to your production environment you are required to send us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

The best postcards will get published on the open source page on our website.

## Install

You can pull in the package via composer:
``` bash
$ composer require spatie/laravel-fractal
```

Next up, the service provider must be registered:

```php
// config/app.php
'providers' => [
    ...
    Spatie\Fractal\FractalServiceProvider::class,

];
```

If you want to make use of the facade you must install it as well:

```php
// config/app.php
'aliases' => [
    ...
    'Fractal' => Spatie\Fractal\FractalFacade::class,
];
```

If you want to [change the default serializer](https://github.com/spatie/laravel-fractal#changing-the-default-serializer),
you must publish the config file:

```bash
php artisan vendor:publish --provider="Spatie\Fractal\FractalServiceProvider"
```

This is the contents of the published file:

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Default Serializer
    |--------------------------------------------------------------------------
    |
    | The default serializer to be used when performing a transformation. It
    | may be left empty to use Fractal's default one. This can either be a
    | string or a League\Fractal\Serializer\SerializerAbstract subclass.
    |
    */

    'default_serializer' => '',

];
```

## Usage

Refer to [the documentation of `spatie/fractalistic`](https://github.com/spatie/fractalistic) to learn all the methods this package provides.

In all code examples you may use `fractal()` instead of `Fractal::create()`.

## Attaching a status code and headers

Now you can easily create fractal responses with status codes and headers.

Previously what you might have done is this ugly JSON response just to attach a response code or headers:
```php
return response()->json(
    fractal()
        ->item('These credentials do not match our records.')
        ->transformWith(new ErrorTransformer)
        ->serializeWith(new ArraySerializer)
        ->toArray()
, 433, $headers);
```
now, you can easily chain on the status code inside the `respond()` method:
```php
return fractal()
    ->item('These credentials do not match our records.')
    ->transformWith(new ErrorTransformer)
    ->serializeWith(new ArraySerializer)
    ->respond(433, $headers);
```

If you have some complicated headers' or status code's connected logic, you can do it in a callback like so:
```php
return fractal()
    ->item('These credentials do not match our records.')
    ->transformWith(new ErrorTransformer)
    ->serializeWith(new ArraySerializer)
    ->respond(function ($response) {
        $response->code(433)
            ->header('test-header', 'test-value')
            ->headers([
                'test2-header' => 'test2-value',
            ]);
    });
```


## Quickly creating a transformer

You can run the `make:transformer` command to quickly generate a dummy transformer. By default it will be stored in the `app\Transformers` directory.

## Upgrading

### From v2 to v3

`v3` was introduced to swap out the `league/fractal` with `spatie/fractalistic`. Support for Lumen was dropped. You should be able to upgrade a Laravel application from `v2` to `v3` without any code changes.
### From v1 to v2

In most cases you can just upgrade to `v2` with making none or only minor changes to your code:

- `resourceName` has been renamed to `withResourceName`.

The main reason why `v2` of this package was tagged is because v0.14 of the underlying [Fractal](http://fractal.thephpleague.com/) by the League contains breaking change. If you use the `League\Fractal\Serializer\JsonApiSerializer` in v2 the `links` key will contain `self`, `first`, `next` and `last`.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Freek Van der Herten](https://twitter.com/freekmurze)
- [All contributors](../../contributors)

## About Spatie
Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
