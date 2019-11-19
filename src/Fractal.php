<?php

namespace Spatie\Fractal;

use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Traits\Macroable;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;
use League\Fractal\Serializer\SerializerAbstract;
use Spatie\Fractalistic\Fractal as Fractalistic;

class Fractal extends Fractalistic
{
    use Macroable {
        Macroable::__call as macroCall;
    }

    /** @param \League\Fractal\Manager $manager */
    public function __construct(Manager $manager)
    {
        parent::__construct($manager);
    }

    /**
     * @param null|mixed $data
     * @param null|callable|\League\Fractal\TransformerAbstract $transformer
     * @param null|\League\Fractal\Serializer\SerializerAbstract $serializer
     *
     * @return \Spatie\Fractalistic\Fractal
     */
    public static function create($data = null, $transformer = null, $serializer = null)
    {
        $fractal = parent::create($data, $transformer, $serializer);

        if (config('fractal.auto_includes.enabled')) {
            $requestKey = config('fractal.auto_includes.request_key');

            if ($include = app('request')->query($requestKey)) {
                $fractal->parseIncludes($include);
            }
        }

        if (empty($serializer)) {
            $serializer = config('fractal.default_serializer');
        }

        if ($data instanceof LengthAwarePaginator) {
            $paginator = config('fractal.default_paginator');

            if (empty($paginator)) {
                $paginator = IlluminatePaginatorAdapter::class;
            }

            $fractal->paginateWith(new $paginator($data));
        }

        if (empty($serializer)) {
            return $fractal;
        }

        if ($serializer instanceof SerializerAbstract) {
            return $fractal->serializeWith($serializer);
        }

        if ($serializer instanceof Closure) {
            return $fractal->serializeWith($serializer());
        }

        if ($serializer == JsonApiSerializer::class) {
            $baseUrl = config('fractal.base_url');

            return $fractal->serializeWith(new $serializer($baseUrl));
        }

        return $fractal->serializeWith(new $serializer);
    }

    /**
     * Return a new JSON response.
     *
     * @param  callable|int $statusCode
     * @param  callable|array $headers
     * @param  callable|int $options
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($statusCode = 200, $headers = [], $options = 0)
    {
        $response = new JsonResponse();

        $response->setData($this->createData()->toArray());

        if (is_int($statusCode)) {
            $statusCode = function (JsonResponse $response) use ($statusCode) {
                return $response->setStatusCode($statusCode);
            };
        }

        if (is_array($headers)) {
            $headers = function (JsonResponse $response) use ($headers) {
                return $response->withHeaders($headers);
            };
        }

        if (is_int($options)) {
            $options = function (JsonResponse $response) use ($options) {
                $response->setEncodingOptions($options);

                return $response;
            };
        }

        if (is_callable($options)) {
            $options($response);
        }

        if (is_callable($statusCode)) {
            $statusCode($response);
        }

        if (is_callable($headers)) {
            $headers($response);
        }

        return $response;
    }

    public function __call($name, array $arguments)
    {
        if (static::hasMacro($name)) {
            return $this->macroCall($name, $arguments);
        }

        return parent::__call($name, $arguments);
    }
}
