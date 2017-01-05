<?php

namespace Spatie\Fractal;

use League\Fractal\Manager;
use Illuminate\Http\JsonResponse;
use Spatie\Fractalistic\Fractal as Fractalistic;

class Fractal extends Fractalistic
{
    /** @var \Spatie\Fractal\Response */
    protected $response;

    /** @param \League\Fractal\Manager $manager */
    public function __construct(Manager $manager)
    {
        parent::__construct($manager);

        $this->response = new Response;
    }

    /**
     * Return a new JSON response.
     *
     * @param  callable|int $callbackOrStatusCode
     * @param  array        $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($callbackOrStatusCode = 200, $callbackOrHeaders = [])
    {
        if (is_callable($callbackOrStatusCode)) {
            $callbackOrStatusCode($this->response);
        } else {
            $this->response->code($callbackOrStatusCode);

            if (is_callable($callbackOrHeaders)) {
                $callbackOrHeaders($this->response);
            } else {
                $this->response->headers($callbackOrHeaders);
            }
        }

        return new JsonResponse($this->createData()->toArray(), $this->response->statusCode(), $this->response->getHeaders());
    }
}
