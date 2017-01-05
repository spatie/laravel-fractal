<?php

namespace Spatie\Fractal;

use Illuminate\Http\JsonResponse;

class Response extends JsonResponse
{
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
