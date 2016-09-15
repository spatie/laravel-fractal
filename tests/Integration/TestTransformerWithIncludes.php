<?php

namespace Spatie\Fractal\Test\Integration;

use League\Fractal\TransformerAbstract;

class TestTransformerWithIncludes extends TransformerAbstract
{
    /**
     * List of resources default includes.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'characters',
        'publisher',
        'title'
    ];

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

    /**
     * Include characters.
     *
     * @param array $book
     *
     * @return \League\Fractal\ItemResource
     */
    public function includeCharacters(array $book)
    {
        $characters = $book['characters'];

        return $this->collection($characters, function ($character) {
            return $character['name'];
        });
    }

    /**
     * Include characters.
     *
     * @param array $book
     *
     * @return \League\Fractal\ItemResource
     */
    public function includePublisher(array $book)
    {
        $publisher = $book['publisher'];

        return $this->item([$publisher], function ($publisher) {
            return $publisher;
        });
    }

    /**
     * Include title.
     *
     * @param array $book
     *
     * @return \League\Fractal\ItemResource
     */
    public function includeTitle(array $book)
    {
        $publisher = $book['title'];

        return $this->item([$publisher], function ($publisher) {
            return $publisher;
        });
    }
}
