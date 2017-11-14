<?php

namespace Spatie\Fractal\Test;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Spatie\Fractal\TransformerAbstract;

class TransformerAbstractTest extends TestCase
{
    /** @test */
    public function it_combines_item_and_collection_includes_attributes_into_available_includes()
    {
        $transformer = new BookTransformer;

        $this->assertEquals(['words', 'author', 'main_characters'], $transformer->getAvailableIncludes());
    }

    /** @test */
    public function it_returns_an_item_for_an_item_relation()
    {
        $item = (new BookTransformer)->includeAuthor(new Book);

        $expectedItem = new Item((new Book)->author, new AuthorTransformer());

        $this->assertEquals($expectedItem, $item);
    }

    /** @test */
    public function it_returns_a_collection_for_a_collection_relation()
    {
        $collection = (new BookTransformer)->includeMainCharacters(new Book);

        $expectedCollection = new Collection((new Book)->main_characters, new mainCharacterTransformer);

        $this->assertEquals($expectedCollection, $collection);
    }

    /** @test */
    public function it_throws_a_bad_method_exception_if_a_nonexistent_method_is_called()
    {
        $this->expectException(\BadMethodCallException::class);

        (new BookTransformer)->badMethod();
    }

    /** @test */
    public function it_includes_an_item_resource()
    {
        $books = [new Book, new Book];

        $resource = new Collection($books, new BookTransformer);
        $output = (new Manager)
            ->parseIncludes('author,main_characters')
            ->createData($resource)
            ->toArray();

        $expected = [
            'data' => [
                [
                    "field"           => "Transformed book",
                    'author'          => [
                        'data' => ["field" => "Transformed author"]
                    ],
                    "main_characters" => [
                        "data" => [
                            ["field" => "Transformed character"],
                            ["field" => "Transformed character"],
                        ]
                    ]
                ],
                [
                    "field"           => "Transformed book",
                    'author'          => [
                        'data' => ["field" => "Transformed author"]
                    ],
                    "main_characters" => [
                        "data" => [
                            ["field" => "Transformed character"],
                            ["field" => "Transformed character"],
                        ]
                    ]
                ]
            ]
        ];

        $this->assertEquals($expected, $output);
    }
}

class BookTransformer extends TransformerAbstract
{
    protected $itemIncludes = ['author' => AuthorTransformer::class];

    protected $collectionIncludes = ['main_characters' => mainCharacterTransformer::class];

    protected $availableIncludes = ['words'];

    public function transform($resource)
    {
        return ['field' => 'Transformed book'];
    }
}

class mainCharacterTransformer extends TransformerAbstract
{
    public function transform($resource)
    {
        return ['field' => 'Transformed character'];
    }
}

class AuthorTransformer extends TransformerAbstract
{
    public function transform($resource)
    {
        return ['field' => 'Transformed author'];
    }
}

class Book
{
    public $author;
    public $main_characters;

    public function __construct()
    {
        $this->author = new \stdclass;
        $this->main_characters = [1, 2];
    }
}
