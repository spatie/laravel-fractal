<?php

namespace Spatie\Fractal;

use League\Fractal\Manager;
use Illuminate\Http\JsonResponse;
use League\Fractal\Serializer\SerializerAbstract;
use Spatie\Fractalistic\Fractal as Fractalistic;

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

        $serializer = config('laravel-fractal.default_serializer');

        if (empty($serializer)) {
            return $fractal;
        }

        if ($serializer instanceof SerializerAbstract) {
            return $fractal->serializeWith($serializer);
        }

        return $fractal->serializeWith(new $serializer());
    }

    /**
     * Return a new JSON response.
     *
     * @param  callable|int $statusCode
     * @param  callable|array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($statusCode = 200, $headers = [])
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

        if (is_callable($statusCode)) {
            $statusCode($response);
        }

        if (is_callable($headers)) {
            $headers($response);
        }

        return $response;
    }
}
