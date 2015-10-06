<?php

namespace Spatie\Fractal\Test\Integration;

use League\Fractal\TransformerAbstract;

class TestTransformer extends TransformerAbstract
{
    /**
     * @param array $book
     *
     * @return array
     */
    public function transform(array $book)
    {
        return [
            'id' => (int) $book['id'],
            'author' => $book['author_name'],
        ];
    }
}
