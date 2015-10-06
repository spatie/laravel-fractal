## WORK IN PROGRESS DO NOT USE

# A Fractal service provider for Laravel 5

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-fractal.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-fractal)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/laravel-fractal/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-fractal)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/9f30e70e-f9d4-4ba2-940e-843788650850.svg?style=flat-square)](https://insight.sensiolabs.com/projects/9f30e70e-f9d4-4ba2-940e-843788650850)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-fractal.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-fractal)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-fractal.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-fractal)

The package provides a nice and easy integration with [Fractal](http://fractal.thephpleague.com/)
for your Laravel 5 projects.

Here how it can be used:

```php
Fractal::collection($someCollection)->transformWith(new YourTransformerClass())->toJson();
```

Spatie is webdesign agency in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

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

## Usage

Coming soon

### Changing the default serializer

Coming soon

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
- [All Contributors](../../contributors)

## About Spatie
Spatie is webdesign agency in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
