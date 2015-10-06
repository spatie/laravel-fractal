<?php

/**
 * @param mixed $collectionOrItem
 * @param League\Fractal\TransformerAbstract|Callable $transformer
 * @param string $outputFormat
 *
 * @return mixed
 */
if (! function_exists('fractal')) {
    function fractal($collectionOrItem, $transformer, $outputFormat = 'array')
    {
        return app(Spatie\Fractal\Fractal::class)
            ->setSubject($collectionOrItem)
            ->setTransformer($transformer)
            ->transform($outputFormat);
    }
}
