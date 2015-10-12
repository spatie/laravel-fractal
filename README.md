# A Fractal service provider for Laravel 5

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-fractal.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-fractal)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/laravel-fractal/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-fractal)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/9f30e70e-f9d4-4ba2-940e-843788650850.svg?style=flat-square)](https://insight.sensiolabs.com/projects/9f30e70e-f9d4-4ba2-940e-843788650850)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-fractal.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-fractal)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-fractal.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-fractal)

The package provides a nice and easy integration with [Fractal](http://fractal.thephpleague.com/)
for your Laravel 5 projects. If you don't know what Fractal does, [take a peek at their intro](http://fractal.thephpleague.com/).
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
   ->includeCharacters();
   ->toArray();
```

Lovers of facades will be glad to know that a facade is provided:
```php
Fractal::collection($books)->transformWith(new BookTransformer())->toArray();
```

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all 
our open source projects [on our website](https://spatie.be/opensource).

## Install

You can pull in the package via composer:
``` bash
$ composer require spatie/laravel-fractal
```

Next up, the service provider must be registered:

### Laravel

Open `config/app.php` and register the required service provider.

```php
'providers' => [
    ...
    Spatie\Fractal\Providers\LaravelServiceProvider::class,

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
php artisan vendor:publish --provider="Spatie\Fractal\Providers\LaravelServiceProvider"
```

This is the contents of the published file:

```php
return [

    /*
     * The default serializer to be used when performing a transformation.
     * Leave empty to use the Fractal's default.
     */
    'default_serializer' => '',
];
```

### Lumen

Open `bootstrap/app.php` and register the required service provider.

```php
$app->register(Spatie\Fractal\Providers\LumenServiceProvider::class);

```

If you want to make use of the facade add this line on `bootstrap/app.php`

```php
class_alias(Spatie\Fractal\FractalFacade::class, 'Fractal');

```

## Usage

In the following examples were going to use the following array as example input:

```php
$books = [['id'=>1, 'title'=>'Hogfather'], ['id'=>2, 'title'=>'Game Of Kill Everyone']];
```

But know that any structure that can be looped (for instance a collection) can be used.

Let's start with a simple transformation.

```php
fractal()
   ->collection($book)
   ->transformWith(function($book) { return ['id' => $book['id']];})
   ->toArray();
``` 

This will return:
```php
['data' => [['id' => 1], ['id' => 2]]
```

Instead of using a closure you can also pass [a Transformer](http://fractal.thephpleague.com/transformers/):

```php
fractal()
   ->collection($book)
   ->transformWith(new BookTransformer())
   ->toArray();
```

To make your code a bit shorter you could also pass the transform closure or class as a 
second parameter of the `collection`-method:

```php
fractal()->collection($book, new BookTransformer())->toArray();
```

Want to get some sweet json output instead of an array? No problem!
```php
fractal()->collection($book, new BookTransformer())->toJson();
```

A single item can also be transformed:
```php
fractal()->item($book[0], new BookTransformer())->toArray();
```

##Using a serializer

Let's take a look again a the output of the first example:

```php
['data' => [['id' => 1], ['id' => 2]];
```

Notice that `data`-key? That's part of Fractal's default behaviour. Take a look at
[Fractals's documentation on serializers](http://fractal.thephpleague.com/serializers/) to find out why that happens.

If you want to use another serializer you can specify one with the `serializeWith`-method.
The `Spatie\Fractal\ArraySerializer` comes out of the box. It removes the `data` namespace for
both collections and items.

```php
fractal()
   ->collection($book)
   ->transformWith(function($book) { return ['id' => $book['id']];})
   ->serializeWith(new \Spatie\Fractal\ArraySerializer())
   ->toArray();

//returns [['id' => 1], ['id' => 2]]
```

### Changing the default serializer

You can change the default serializer by providing the classname of your favorite serializer in
the config file.

## Using includes

Fractal provides support for [optionally including data](http://fractal.thephpleague.com/transformers/) on the relationships for
the data you're exporting. You can use Fractal's `parseIncludes` which accepts a string or an array:

```php
fractal()
   ->collection($this->testBooks, new TestTransformer())
   ->parseIncludes(['characters', 'publisher'])
   ->toArray();
```

To improve readablity you can also a function named `include` followed by the name
of the include you want to... include:

```php
fractal()
   ->collection($this->testBooks, new TestTransformer())
   ->includeCharacters()
   ->includePublisher()
   ->toArray();
```

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
