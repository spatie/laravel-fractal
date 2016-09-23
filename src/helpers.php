<?php

use Spatie\Fractal\FractalFunctionHelper;

if (! function_exists('fractal')) {

    /** @return \Spatie\Fractal\Fractal */
    function fractal()
    {
        $fractalFunctionHelper = new FractalFunctionHelper(func_get_args());

        return $fractalFunctionHelper->getFractalInstance();
    }
}
