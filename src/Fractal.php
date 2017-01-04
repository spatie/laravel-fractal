<?php

namespace Spatie\Fractal;

use Illuminate\Http\JsonResponse;
use League\Fractal\Manager;
use Spatie\Fractalistic\Fractal as Fractalistic;

class Fractal extends Fractalistic
{
    protected $response;

    public function __construct(Manager $manager)
    {
        parent::__construct($manager);

        $this->response = new Response;
    }

    public function respond($callbackOrStatusCode = 200, $headers = [])
    {
        if (is_callable($callbackOrStatusCode)) {
            $callbackOrStatusCode($this->response);
        } else {
            $this->response->code($callbackOrStatusCode);
        }

        return new JsonResponse($this->createData()->toArray(), $this->response->statusCode(), $headers);
    }
}
