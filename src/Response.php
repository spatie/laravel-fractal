<?php

namespace Spatie\Fractal;

class Response
{
    /** @var int */
    protected $statusCode = 200;

    /** @var array */
    protected $headers = [];

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
     * Set one HTTP header.
     *
     * @param  string $key
     * @param  string $value
     *
     * @return self
     */
    public function header($key, $value)
    {
        $this->headers[$key] = $value;

        return $this;
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
