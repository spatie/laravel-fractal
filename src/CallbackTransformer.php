<?php

namespace Spatie\Fractal;

use League\Fractal\TransformerAbstract;

class CallbackTransformer extends TransformerAbstract
{
    /** @var callable */
    protected $callable;

    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * @param mixed $item
     *
     * @return array
     */
    public function transform($item)
    {
        $callable = $this->callable;

        return $callable($item);
    }
}
