<?php

namespace Spatie\Fractal;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\Fractal\Fratal
 */
class FractalFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-fractal';
    }
}
