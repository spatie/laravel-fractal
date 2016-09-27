<?php

namespace Spatie\Fractal;

use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;
use Spatie\Fractal\Exceptions\InvalidUseOfFractalHelper;
use Traversable;

class FractalFunctionHelper
{
    /** @var \Spatie\Fractal\Fractal */
    protected $fractal;

    /** @var array */
    protected $arguments;

    public function __construct($arguments)
    {
        $this->fractal = app(Fractal::class);

        $this->arguments = $arguments;
    }

    /**
     * @return \Spatie\Fractal\Fractal
     *
     * @throws \Spatie\Fractal\Exceptions\InvalidUseOfFractalHelper
     */
    public function getFractalInstance()
    {
        if (count($this->arguments) === 1) {
            throw InvalidUseOfFractalHelper::secondArgumentMissing();
        }

        if (count($this->arguments) >= 2) {
            $this->setData($this->arguments[0]);

            $this->setTransformer($this->arguments[1]);
        }

        if (count($this->arguments) >= 3) {
            $this->setSerializer($this->arguments[2]);
        }

        if (count($this->arguments) > 3) {
            throw InvalidUseOfFractalHelper::tooManyArguments($this->arguments);
        }

        return $this->fractal;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $dataType = $this->determineDataType($data);

        $this->fractal->data($dataType, $data);
    }

    /**
     * @param mixed $data
     *
     * @return string
     */
    protected function determineDataType($data)
    {
        if (is_array($data)) {
            return 'collection';
        }

        if ($data instanceof Traversable) {
            return 'collection';
        }

        return 'item';
    }

    /**
     * @param callable|\League\Fractal\TransformerAbstract $transformer
     */
    protected function setTransformer($transformer)
    {
        $this->fractal->transformWith($transformer);
    }

    protected function setSerializer(SerializerAbstract $serializer)
    {
        $this->fractal->serializeWith($serializer);
    }
}
