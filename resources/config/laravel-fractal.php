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
    | JsonApiSerializer links support
    |--------------------------------------------------------------------------
    |
    | Enables links support for League\Fractal\Serializer\JsonApiSerializer.
    | It automatically generates links for transformable entities.
    |
    */
    'base_url' => null,

];
