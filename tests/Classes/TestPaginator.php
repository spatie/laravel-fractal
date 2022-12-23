<?php

namespace Spatie\Fractal\Test\Classes;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class TestPaginator extends IlluminatePaginatorAdapter
{
    /**
     * Get a fake total, for testing.
     *
     * @return int
     */
    public function getTotal(): int
    {
        return 9999;
    }
}
