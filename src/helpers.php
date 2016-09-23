<?php

use Spatie\Fractal\FractalFunctionHelper;

if (! function_exists('fractal')) {
    function fractal()
    {
        $fractalFunctionHelper = new FractalFunctionHelper(func_get_args());

        return $fractalFunctionHelper->getFractalInstance();
    }
}
