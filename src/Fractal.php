<?php

namespace Spatie\Fractal;

use Spatie\Fractalistic\Fractal as Fractalistic;

class Fractal extends Fractalistic
{
    public function respond()
    {
        return response()->json($this->createData()->toArray());
    }
}
