<?php

namespace Spatie\Fractal\Exceptions;

use InvalidArgumentException;

class InvalidFractalHelperArgument extends InvalidArgumentException
{
    public static function secondArgumentMissing()
    {
        return new static('The second argument should be a callable or extend `League\\Fractal\\TransformerAbstract`');
    }

    public static function tooManyArguments(array $arguments)
    {
        $argumentCount = count($arguments);

        return new static("You passed {$argumentCount} to `fractal()`. The maximum amount of arguments is 3.");
    }

    public static function invalidTransformer()
    {
        return new static('The second argument should be a callable or extend `League\\Fractal\\TransformerAbstract`');
    }
}
