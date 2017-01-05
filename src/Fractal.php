<?php

namespace Spatie\Fractal;

use League\Fractal\Manager;
use Spatie\Fractalistic\Fractal as Fractalistic;

class Fractal extends Fractalistic
{
    /** @param \League\Fractal\Manager $manager */
    public function __construct(Manager $manager)
    {
        parent::__construct($manager);
    }

    /**
     * Return a new JSON response.
     *
     * @param  callable|int $statusCode
     * @param  callabel|array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($statusCode = 200, $headers = [])
    {
        $response = new Response();

        $response->setData($this->createData()->toArray());

        if (is_int($statusCode)) {
            $statusCode = function (Response $response) use ($statusCode) {
                return $response->setStatusCode($statusCode);
            };
        }

        if (is_array($headers)) {
            $headers = function (Response $response) use ($headers) {
                return $response->headers($headers);
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
