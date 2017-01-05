<?php

namespace Spatie\Fractal;

use Illuminate\Http\JsonResponse;

class Response extends JsonResponse
{
    /** @var int */
    protected $statusCode = 200;

    /** @var array */
    public $headers = [];

    /**
     * Return HTTP headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set multiple headers at once.
     *
     * @param  array $headers
     *
     * @return self
     */
    public function headers($headers)
    {
        foreach ($headers as $key => $value) {
            $this->header($key, $value);
        }

        return $this;
    }
}
