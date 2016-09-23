<?php

namespace Spatie\Fractal\Exceptions;

use Exception;

class InvalidUseOfFractalHelper extends Exception
{
    public static function secondArgumentMissing()
    {
        return new static('The second argument should be a callable or extend `League\\Fractal\\TransformerAbstract`');
    }
}
