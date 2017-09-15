<?php

namespace Spatie\Fractal;

use Closure;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use League\Fractal\Serializer\JsonApiSerializer;
use Spatie\Fractalistic\Fractal as Fractalistic;
use League\Fractal\Serializer\SerializerAbstract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class Fractal extends Fractalistic
{
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

            if (app('request')->query($requestKey)) {
                $fractal->parseIncludes(explode(',', app('request')->query($requestKey)));
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
}
