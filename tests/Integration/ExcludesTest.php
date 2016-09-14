<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 14/09/2016
 * Time: 15.00
 */

namespace Spatie\Fractal\Test\Integration;

class ExcludesTest extends TestCase
{
	/**
	 * @test
	 */
	public function it_can_parse_excludes()
	{
		$array = $this->fractal
			->collection($this->testPosts, new TestPostsTransformer())
			->parseExcludes('author')
			->toArray();

		$expectedArray = [
			'data' => [
				['id' => 1, 'title' => 'Hogfather', 'characters' => ['data' => ['Death', 'Hex']]],
				[
					'id' => 2,
					'title' => 'Game Of Kill Everyone',
					'characters' => ['data' => ['Ned Stark', 'Tywin Lannister']],
				],
			],
		];

		$this->assertEquals($expectedArray, $array);
	}

	/**
	 * @test
	 */
	public function it_provides_a_convenience_method_to_exclude_excludes()
	{
		$resultWithParseIncludes = fractal()
			->collection($this->testPosts, new TestPostsTransformer())
			->parseExcludes('author')
			->toArray();

		$resultWithParseCharacters = fractal()
			->collection($this->testPosts, new TestPostsTransformer())
			->excludeAuthor()
			->toArray();

		$this->assertEquals($resultWithParseIncludes, $resultWithParseCharacters);
	}

	/**
	 * @test
	 */
	public function it_can_handle_multiple_excludes()
	{
		$array = $this->fractal
			->collection($this->testBooks, new TestPostsTransformer())
			->excludeAuthor()
			->excludeCharacters()
			->toArray();

		$expectedArray = [
			'data' => [
				['id' => 1, 'title' => 'Hogfather'],
				['id' => 2, 'title' => 'Game Of Kill Everyone'],
			],
		];

		$this->assertEquals($expectedArray, $array);
	}

	/**
	 * @test
	 */
	public function it_can_handle_multiple_includes_at_once()
	{
		$array = $this->fractal
			->collection($this->testPosts, new TestPostsTransformer())
			->parseExcludes('characters, author')
			->toArray();

		$expectedArray = [
			'data' => [
				['id' => 1, 'title' => 'Hogfather'],
				['id' => 2, 'title' => 'Game Of Kill Everyone'],
			],
		];

		$this->assertEquals($expectedArray, $array);
	}

	/**
	 * @test
	 */
	public function it_knows_to_ignore_invalid_includes_param()
	{
		$excludeWhenPassedNull = $this->fractal
			->collection($this->testPosts, new TestPostsTransformer())
			->parseExcludes(null)
			->toArray();

		$excludeWhenPassedEmptyArray = $this->fractal
			->collection($this->testPosts, new TestPostsTransformer())
			->parseExcludes([])
			->toArray();

		$expectedArray = ["data" => [
			[
				"id" => 1, "title" => "Hogfather",
					"author" => ["data" => ["George R. R. Satan", "george@example.org"]],
					"characters" => ["data" => ["Death", "Hex"]]],
				["id" => 2, "title" => "Game Of Kill Everyone",
					"author" => ["data" => ["George R. R. Satan", "george@example.org",]],
					"characters" => ["data" => ["Ned Stark", "Tywin Lannister",]]
				],
			],
		];

		$this->assertEquals($expectedArray, $excludeWhenPassedEmptyArray);
		$this->assertEquals($expectedArray, $excludeWhenPassedNull);
	}
}