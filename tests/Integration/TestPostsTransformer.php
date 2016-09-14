<?php

namespace Spatie\Fractal\Test\Integration;

use League\Fractal\TransformerAbstract;

class TestPostsTransformer extends TransformerAbstract
{
	protected $defaultIncludes = [
		'author',
		'characters'
	];

    /**
     * @param array $book
     *
     * @return array
     */
    public function transform(array $post)
    {
        return [
            'id' => (int) $post['id'],
            'title' => $post['title']
        ];
    }

    /**
     * Include characters.
     *
     * @param array $book
     *
     * @return \League\Fractal\ItemResource
     */
    public function includeCharacters(array $post)
    {
        $characters = $post['characters'];

        return $this->collection($characters, function ($character) {
            return $character['name'];
        });
    }

	/**
	 * Include author.
	 *
	 * @param array $book
	 *
	 * @return \League\Fractal\ItemResource
	 */
	public function includeAuthor(array $book)
	{
		$characters = $book['author'];

		return $this->collection($characters, function ($character) {
			return $character;
		});
	}
}
