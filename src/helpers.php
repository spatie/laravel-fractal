<?php

use Spatie\Fractal\FractalFunctionHelper;

if (! function_exists('fractal')) {
    /**
     * @param null|mixed $data
     * @param null|callable|\League\Fractal\TransformerAbstract $transformer
     * @param null|\League\Fractal\Serializer\SerializerAbstract $serializer
     *
     * @return \Spatie\Fractal\Fractal
     */
    function fractal()
    {
        $fractalFunctionHelper = new FractalFunctionHelper(func_get_args());

        return $fractalFunctionHelper->getFractalInstance();
    }
}
