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
    | League\Fractal\Serializer\JsonApiSerializer will use this value to
    | as a prefix for generated links. Set to `null` to disable this.
    |
    */
    'base_url' => null,

];
