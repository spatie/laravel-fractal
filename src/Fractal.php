<?php

namespace Spatie\Fractal;

use League\Fractal\Manager;
use League\Fractal\Serializer\SerializerAbstract;
use Spatie\Fractal\Exceptions\InvalidTransformation;
use Spatie\Fractal\Exceptions\NoTransformerSpecified;

class Fractal
{
    /**
     * @var Manager
     */
    protected $manager;

    /**
     * @var \League\Fractal\Serializer\SerializerAbstract
     */
    protected $serializer;

    /**
     * @var \League\Fractal\TransformerAbstract|Callable
     */
    protected $transformer;

    /**
     * @var string
     */
    protected $dataType;

    /**
     * @var Mixed
     */
    protected $data;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Set the collection data that must be transformed.
     *
     * @param mixed                                             $data
     * @param \League\Fractal\TransformerAbstract|Callable|null $transformer
     *
     * @return $this
     */
    public function collection($data, $transformer = null)
    {
        return $this->data('collection', $data, $transformer);
    }

    /**
     * Set the item data that must be transformed.
     *
     * @param mixed                                             $data
     * @param \League\Fractal\TransformerAbstract|Callable|null $transformer
     *
     * @return $this
     */
    public function item($data, $transformer = null)
    {
        return $this->data('item', $data, $transformer);
    }

    /**
     * Set the data that must be transformed.
     *
     * @param string                                            $dataType
     * @param mixed                                             $data
     * @param \League\Fractal\TransformerAbstract|Callable|null $transformer
     *
     * @return $this
     */
    protected function data($dataType, $data, $transformer = null)
    {
        $this->dataType = $dataType;

        $this->data = $data;

        if (!is_null($transformer)) {
            $this->transformer = $transformer;
        }

        return $this;
    }

    /**
     * Set the class or function that will perform the transform.
     *
     * @param \League\Fractal\TransformerAbstract|Callable $transformer
     *
     * @return $this
     */
    public function transformWith($transformer)
    {
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * Set the serializer to be used.
     *
     * @param  \League\Fractal\Serializer\SerializerAbstract $serializer
     */
    public function serializeWith(SerializerAbstract $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Perform the transformation to json.
     *
     * @return mixed
     */
    public function toJson()
    {
        return $this->transform('json');
    }

    /**
     * Perform the transformation to array.
     *
     * @return mixed
     */
    public function toArray()
    {
        return $this->transform('array');
    }

    /**
     *  Perform the transformation.
     *
     * @param string $format
     * @return mixed
     * @throws \Spatie\Fractal\Exceptions\InvalidTransformation
     * @throws \Spatie\Fractal\Exceptions\NoTransformerSpecified
     */
    protected function transform($format)
    {
        if (is_null($this->transformer)) throw new NoTransformerSpecified;

        if (!is_null($this->serializer)) {
            $this->manager->setSerializer($this->serializer);
        }

        $resource = $this->getResource();

        $fractalData = $this->manager->createData($resource);

        $conversionMethod = 'to'.ucFirst($format);

        return $fractalData->$conversionMethod();
    }

    /**
     * Get the resource.
     * @return \League\Fractal\Resource\Collection;
     * @throws \Spatie\Fractal\Exceptions\InvalidTransformation
     */
    protected function getResource()
    {
        $resourceClass = "League\\Fractal\\Resource\\".ucfirst($this->dataType);

        if (! class_exists($resourceClass)) throw new InvalidTransformation;

        return new $resourceClass($this->data, $this->transformer);
    }
}
