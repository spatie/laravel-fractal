<?php

namespace Spatie\Fractal;

class Response
{
    protected $statusCode;

    public function statusCode()
    {
        return $this->statusCode;
    }

    public function code($statusCode)
    {
        $this->statusCode = $statusCode;
    }
}
