<?php

namespace Spatie\Fractal;

use Spatie\Fractalistic\Fractal as Fractalistic;

class Fractal extends Fractalistic
{
    public function respond($statusCode = 200)
    {
        return response()->json($this->createData()->toArray(), $statusCode);
    }
}
