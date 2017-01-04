<?php

namespace Spatie\Fractal;

class Response
{
    protected $statusCode;
    protected $headers = [];

    public function statusCode()
    {
        return $this->statusCode;
    }

    public function code($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function header($key, $value)
    {
        $this->headers[$key] = $value;
    }

    public function headers($headers)
    {
        foreach ($headers as $key => $value) {
            $this->header($key, $value);
        }
    }
}
