<?php

namespace Spatie\Fractal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract as FractalTransformer;

abstract class TransformerAbstract extends FractalTransformer
{
    /**
     * @var array
     */
    protected $itemIncludes = [];

    /**
     * @var array
     */
    protected $collectionIncludes = [];

    /**
     * TransformerAbstract constructor.
     */
    public function __construct()
    {
        $this->availableIncludes = array_merge($this->availableIncludes,
            array_keys($this->itemIncludes),
            array_keys($this->collectionIncludes));
    }

    /**
     * Simulate 'includeResource()' methods.
     *
     * @param string $method
     * @param array  $arguments
     * @return Collection|Item
     */
    public function __call($method, $arguments)
    {
        $baseResource = $arguments[0] ?? null;
        $relatedResource = Str::snake(preg_replace('/^include/', '', $method));

        if (array_key_exists($relatedResource, $this->itemIncludes)) {
            return $this->item($baseResource->{$relatedResource}, new $this->itemIncludes[$relatedResource]);
        }

        if (array_key_exists($relatedResource, $this->collectionIncludes)) {
            return $this->collection(
                $baseResource->{$relatedResource}, new $this->collectionIncludes[$relatedResource]);
        }

        throw new \BadMethodCallException('Unknown method "' . $method . '" called on ' . static::class . '.');
    }
}
