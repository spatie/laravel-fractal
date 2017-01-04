<?php

use Spatie\Fractal\Fractal;
use League\Fractal\Serializer\SerializerAbstract;

if (! function_exists('fractal')) {
    /**
     * @param null|mixed $data
     * @param null|callable|\League\Fractal\TransformerAbstract $transformer
     * @param null|\League\Fractal\Serializer\SerializerAbstract $serializer
     *
     * @return \Spatie\Fractal\Fractal
     */
    function fractal($data = null, $transformer = null, $serializer = null)
    {
        $fractal = Fractal::create($data, $transformer, $serializer);

        $serializer = config('laravel-fractal.default_serializer');

        if (! empty($serializer)) {
            if ($serializer instanceof SerializerAbstract) {
                $fractal->serializeWith($serializer);
            } else {
                $fractal->serializeWith(new $serializer());
            }
        }

        return $fractal;
    }
}
