<?php

use Spatie\Fractalistic\FractalFunctionHelper;

if (! function_exists('fractal')) {
    /**
     * @return \Spatie\Fractalistic\Fractal
     */
    function fractal()
    {
        $fractalFunctionHelper = new FractalFunctionHelper(func_get_args());

        return $fractalFunctionHelper->getFractalInstance();
    }
}
