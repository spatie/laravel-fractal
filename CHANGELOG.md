# Changelog

All notable changes to `laravel-fractal` will be documented in this file

## 3.1.3 - 2017-01-17

- fixed missing namespace import in Fractal

## 3.1.2 - 2017-01-17

- the facade will now use the configured serializer

## 3.1.1 - 2017-01-08

- fix wrong implementation of the `respond` method.

If you encounter errors when upgrading from `3.1.0` to this version, replace all usages of `Spatie\Fractal\Response` by `Illuminate\Http\JsonResponse`. All calls to the `headers` method on that class should be replaced by `withHeaders`.

## 3.1.0 - 2017-01-05

- add `respond` method

## 3.0.1 - 2016-12-09

- fix dependencies in `composer.json`

## 3.0.0 - 2016-12-09

- make use of `spatie/fractalistic`

## 2.1.0 - 2016-12-02

- add `make:transformer` artisan command.

## 2.0.0 - 2016-09-27

- made compatible with fractal `0.14`
- improvements to the `fractal`-helper function.
- added excludes

## 1.9.1 - 2016-08-23

- Added L5.3 compatibility

## 1.9.0 - 2016-03-30

- Added support for cursors

## 1.8.0 - 2016-02-18

- The `Fractal`-class now implements the `JsonSerializable`-interface

## 1.7.4 - 2015-12-16
- Fixed a bug when passing a null value to parseIncludes

## 1.7.3 - 2015-11-09

### Fixed
- Fixed bug when adding multiple includes in one go

## 1.7.2 - 2015-11-09

### Fixed
- Fix for adding multiple includes in one go.

** this version contains a bug when adding multiple includes in one go, please upgrade to v1.7.3 **

## 1.7.1 - 2015-10-26

### Fixed
- Fix for setting the default_serializer as an instantiation in Lumen

## 1.7.0 - 2015-10-26

### Added
- Allow default_serializer to be set as an instantiation

## 1.6.1 - 2015-10-21

### Fixed
- dependency version number of fractal in composer.json

## 1.6.0 - 2015-10-20

### Added
- compatiblity with version v0.13 of Fractal

Please not that the output of `JsonApiSerializer` has been changed in v0.13 of Fractal.

## 1.5.0 - 2015-10-14

### Added
- Support for including meta data

## 1.4.0 - 2015-10-13

### Added
- Pagination methods
- Custom resource names

## 1.3.0 - 2015-10-13

### Added
- Support for Lumen

## 1.2.0 - 2015-10-11

### Added
- Methods to use includes
- Create data method

## 1.1.0 - 2015-10-08

### Changed
- Made the `getResource`-function public

## 1.0.0 - 2015-10-07

### Added
- Everything, initial release
