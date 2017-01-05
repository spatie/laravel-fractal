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
     * Get the status code.
     *
     * @return int
     */
    public function statusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set the status code.
     *
     * @param  int $statusCode
     *
     * @return self
     */
    public function code($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

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
