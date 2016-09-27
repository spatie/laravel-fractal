<?php

use Spatie\Fractal\FractalFunctionHelper;

if (! function_exists('fractal')) {
    /**
     * @param mixed $data
     * @param callable|\League\Fractal\TransformerAbstract $transformer
     * @param \League\Fractal\Serializer\SerializerAbstract $serializer
     *
     * @return \Spatie\Fractal\Fractal
     */
    function fractal()
    {
        $fractalFunctionHelper = new FractalFunctionHelper(func_get_args());

        return $fractalFunctionHelper->getFractalInstance();
    }
}
