<?php

namespace Spatie\Fractal\Test\Integration;

class ExcludesTest extends TestCase
{
    /** @test */
    public function it_can_parse_excludes()
    {
        $array = $this->fractal
            ->collection($this->testBooks, new TestTransformerWithIncludes())
            ->parseExcludes('publisher')
            ->toArray();

        $expectedArray = [
            'data' => [
                ['id' => 1, 'author' => 'Philip K Dick', 'title' => ['data' => ['Hogfather']], 'characters' => ['data' => ['Death', 'Hex']]],
                ['id' => 2, 'author' => 'George R. R. Satan', 'title' => ['data' => ['Game Of Kill Everyone']], 'characters' => ['data' => ['Ned Stark', 'Tywin Lannister']]],
            ],
        ];

        $this->assertEquals($expectedArray, $array);
    }

    /**
     * @test
     */
    public function it_provides_a_convenience_method_to_exclude_excludes()
    {
        $resultWithParseExcludes = fractal()
            ->collection($this->testBooks, new TestTransformerWithIncludes())
            ->parseExcludes('publisher')
            ->toArray();

        $resultWithParseExcludesAsaMethod = fractal()
            ->collection($this->testBooks, new TestTransformerWithIncludes())
            ->excludePublisher()
            ->toArray();

        $this->assertEquals($resultWithParseExcludes, $resultWithParseExcludesAsaMethod);
    }

    /**
     * @test
     */
    public function it_can_handle_multiple_excludes()
    {
        $array = $this->fractal
            ->collection($this->testBooks, new TestTransformerWithIncludes())
            ->excludePublisher()
            ->excludeCharacters()
            ->toArray();

        $expectedArray = [
            'data' => [
                ['id' => 1, 'author' => 'Philip K Dick', 'title' => ['data' => ['Hogfather']]],
                ['id' => 2, 'author' => 'George R. R. Satan', 'title' => ['data' => ['Game Of Kill Everyone']]],
            ],
        ];

        $this->assertEquals($expectedArray, $array);
    }

    /**
     * @test
     */
    public function it_can_handle_multiple_excludes_at_once()
    {
        $array = $this->fractal
            ->collection($this->testBooks, new TestTransformerWithIncludes())
            ->parseExcludes('characters, title')
            ->toArray();

        $expectedArray = [
            'data' => [
                ['id' => 1, 'author' => 'Philip K Dick', 'publisher' => ['data' => ['Elephant books']]],
                ['id' => 2, 'author' => 'George R. R. Satan', 'publisher' => ['data' => ['Bloody Fantasy inc.']]],
            ],
        ];

        $this->assertEquals($expectedArray, $array);
    }

    /**
     * @test
     */
    public function it_knows_to_ignore_invalid_excludes_param()
    {
        $expectedArray = [
            'data' => [
                ['id' => 1, 'author' => 'Philip K Dick', 'characters' => ['data' => ['Death', 'Hex']], 'publisher' => ['data' => ['Elephant books']], 'title' => ['data' => ['Hogfather']]],
                ['id' => 2, 'author' => 'George R. R. Satan', 'characters' => ['data' => ['Ned Stark', 'Tywin Lannister']], 'publisher' => ['data' => ['Bloody Fantasy inc.']], 'title' => ['data' => ['Game Of Kill Everyone']]],
            ],
        ];

        $excludeWhenPassedNull = $this->fractal
            ->collection($this->testBooks, new TestTransformerWithIncludes())
            ->parseExcludes(null)
            ->toArray();

        $this->assertEquals($expectedArray, $excludeWhenPassedNull);

        $excludeWhenPassedEmptyArray = $this->fractal
            ->collection($this->testBooks, new TestTransformerWithIncludes())
            ->parseExcludes([])
            ->toArray();

        $this->assertEquals($expectedArray, $excludeWhenPassedEmptyArray);
    }
}
