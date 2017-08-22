<?php

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

    /*
    |--------------------------------------------------------------------------
    | Default Paginator
    |--------------------------------------------------------------------------
    |
    | The default paginator to be used when performing a transformation. It
    | may be left empty to use Fractal's default one. This can either be a
    | string or a League\Fractal\Paginator\PaginatorInterface subclass.
    |
    */

    'default_paginator' => '',

    /*
    |--------------------------------------------------------------------------
    | JsonApiSerializer links support
    |--------------------------------------------------------------------------
    |
    | League\Fractal\Serializer\JsonApiSerializer will use this value to
    | as a prefix for generated links. Set to `null` to disable this.
    |
    */
    'base_url' => null,

    /*
    |--------------------------------------------------------------------------
    | Fractal Class
    |--------------------------------------------------------------------------
    |
    | If you wish to override or extend the default Spatie\Fractal\Fractal
    | instance provide the name of the class you want to use.
    |
    */
    'fractal_class' => Spatie\Fractal\Fractal::class,

];
