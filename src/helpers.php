<?php

use Spatie\Fractal\Fractal;

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
        $class = config('laravel-fractal.fractal_class');
        $class = empty($class) ? Fractal::class : $class;

        return $class::create($data, $transformer, $serializer);
    }
}
