<?php

namespace Spatie\Fractal;

use Illuminate\Contracts\Config\Repository;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class Fractal
{
    /**
     * @var Manager
     */
    protected $manager;

    /**
     * @param \League\Fractal\TransformerAbstract|Callable $transformer
     */
    protected $transformer;

    protected $subject;
    /**
     * @var Repository
     */
    protected $config;

    public function __construct(Manager $manager, Repository $config)
    {
        $this->manager = $manager;
        $this->config = $config;
    }

    /**
     * Set the collection or item that must be transformed.
     *
     * @param $subject
     *
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Set the class or function that will perform the transform.
     *
     * @param \League\Fractal\TransformerAbstract|Callable $transformer
     *
     * @return $this
     */
    public function setTransformer($transformer)
    {
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * Get the resource.
     *
     * @return Collection
     */
    public function getResource()
    {
        return new Collection($this->subject, $this->transformer);
    }

    /**
     * Get the data.
     *
     * @return \League\Fractal\Scope
     */
    public function getData()
    {
        return $this->manager->createData($this->getResource());
    }

    /**
     *  Perform the transformation.
     *
     * @param string $format
     *
     * @return mixed
     */
    public function transform($format = '')
    {
        if ($format == '') {
            $format == $this->getDefaultFormat();
        }

        $conversionMethod = 'to'.ucFirst($format);

        return $this->getData()->$conversionMethod();
    }

    protected function getDefaultFormat()
    {
        return $this->config->get('laravel-fractal.default_output_format');
    }
}
