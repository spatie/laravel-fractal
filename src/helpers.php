<?php


if (! function_exists('fractal')) {

    /**
     * @return \Spatie\Fractal\Fractal
     */
    function fractal()
    {
        return app(\Spatie\Fractal\Fractal::class);
    }
}
