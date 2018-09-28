# Changelog

All notable changes to `laravel-fractal` will be documented in this file

## 5.4.2 - 2018-09-28

- support Lumen

## 5.4.1 - 2018-08-24

- add support for Laravel 5.7

## 5.4.0 - 2018-07-19

- make fractal macroable

## 5.3.2 - 2018-06-13

- fixed #153

## 5.3.1 - 2018-02-08

- add support for L5.6

## 5.3.0 - 2017-11-28

- add `transformWith` collection macro

## 5.2.0 - 2017-09-15

- add compatibility with Lumen 5.5

## 5.1.0 - 2017-09-08

- allow json encoding options to be passed to the `respond` method

## 5.0.1 - 2017-08-30

- Fix wrongly tagged commit

## 5.0.0 - 2017-08-30

- Laravel 5.5 support, dropped support for all older versions
- renamed config file from `laravel-fractal` to `fractal`
- added auto-includes

## 4.5.0 - 2017-08-20
- add `default_paginator` to config file

## 4.4.0 - 2017-08-20
- add `fractal_class` to config file

## 4.3.0 - 2017-07-26
- Add baseUrl support for the JsonApi serializer

## 4.2.0 - 2017-07-18
- Nothing changed! Something went wrong with tagging the last version so we had to bump the version a bit?

## 4.0.1 - 2017-05-05
- Fixes bug where a passed serializer wouldn't be used

## 4.0.0 - 2017-04-26
- Add compatiblity with fractal 0.16 through fractalistic 2.0

## 3.5.0 - 2017-02-22
- Add compatiblity with Lumen

## 3.4.1 - 2017-02-07
- Fix resolving `Fractal::class` out of the container

## 3.4.0 - 2017-02-04
- Add support for passing paginators to the `data` argument of `fractal()`

## 3.3.1 - 2017-01-27
- Bind `laravel-fractal` as a singleton

## 3.3.0 - 2017-01-23
- Add support for Laravel 5.4

## 3.2.1 - 2017-01-20
- Improve descriptions of generator command

## 3.2.0 - 2017-01-14
- Allow closures to be used as serializers

## 3.1.3 - 2017-01-08
- Fixed missing namespace import in Fractal

## 3.1.2 - 2017-01-08
- The facade will now use the configured serializer

## 3.1.1 - 2017-01-08
- Fix wrong implementation of the `respond` method.

If you encounter errors when upgrading from `3.1.0` to this version, replace all usages of `Spatie\Fractal\Response` by `Illuminate\Http\JsonResponse`. All calls to the `headers` method on that class should be replaced by `withHeaders`.

## 3.1.0 - 2017-01-05
- Add `respond` method

## 3.0.1 - 2016-12-09
- Fix dependencies in `composer.json`

## 3.0.0 - 2016-12-09
- Make use of `spatie/fractalistic`

## 2.1.0 - 2016-12-02
- Add `make:transformer` artisan command.

## 2.0.0 - 2016-09-27
- Made compatible with fractal `0.14`
- Improvements to the `fractal`-helper function.
- Added excludes

## 1.9.1 - 2016-08-23
- Added L5.3 compatibility

## 1.9.0 - 2016-03-30
- Added support for cursors

## 1.8.0 - 2016-02-18
- The `Fractal`-class now implements the `JsonSerializable`-interface

## 1.7.4 - 2015-12-16
- Fixed a bug when passing a null value to parseIncludes

## 1.7.3 - 2015-11-09
- Fixed bug when adding multiple includes in one go

## 1.7.2 - 2015-11-09
- Fix for adding multiple includes in one go.

** this version contains a bug when adding multiple includes in one go, please upgrade to v1.7.3 **

## 1.7.1 - 2015-10-26
- Fix for setting the default_serializer as an instantiation in Lumen

## 1.7.0 - 2015-10-26
- Allow default_serializer to be set as an instantiation

## 1.6.1 - 2015-10-21
- Dependency version number of fractal in composer.json

## 1.6.0 - 2015-10-20
- Compatiblity with version v0.13 of Fractal

Please not that the output of `JsonApiSerializer` has been changed in v0.13 of Fractal.

## 1.5.0 - 2015-10-14
- Support for including meta data

## 1.4.0 - 2015-10-13
- Pagination methods
- Custom resource names

## 1.3.0 - 2015-10-13
- Support for Lumen

## 1.2.0 - 2015-10-11
- Methods to use includes
- Create data method

## 1.1.0 - 2015-10-08
- Made the `getResource`-function public

## 1.0.0 - 2015-10-07
- Initial release
