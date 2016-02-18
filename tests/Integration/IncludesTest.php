<?php

namespace Spatie\Fractal\Test\Integration;

class IncludesTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_parse_includes()
    {
        $array = $this->fractal
            ->collection($this->testBooks, new TestTransformer())
            ->parseIncludes('characters')
            ->toArray();

        $expectedArray = ['data' => [
            ['id' => 1, 'author' => 'Philip K Dick',  'characters' => ['data' => ['Death', 'Hex']]],
            ['id' => 2, 'author' => 'George R. R. Satan', 'characters' => ['data' => ['Ned Stark', 'Tywin Lannister']]],
        ]];

        $this->assertEquals($expectedArray, $array);
    }

    /**
     * @test
     */
    public function it_provides_a_convenience_method_to_include_includes()
    {
        $resultWithParseIncludes = fractal()
            ->collection($this->testBooks, new TestTransformer())
            ->parseIncludes('characters')
            ->toArray();

        $resultWithParseCharacters = fractal()
            ->collection($this->testBooks, new TestTransformer())
            ->includeCharacters()
            ->toArray();

        $this->assertEquals($resultWithParseIncludes, $resultWithParseCharacters);
    }

    /**
     * @test
     */
    public function it_can_handle_multiple_includes()
    {
        $array = $this->fractal
            ->collection($this->testBooks, new TestTransformer())
            ->includeCharacters()
            ->includePublisher()
            ->toArray();

        $expectedArray = ['data' => [
            ['id' => 1, 'author' => 'Philip K Dick',  'characters' => ['data' => ['Death', 'Hex']], 'publisher' => ['data' => ['Elephant books']]],
            ['id' => 2, 'author' => 'George R. R. Satan', 'characters' => ['data' => ['Ned Stark', 'Tywin Lannister']], 'publisher' => ['data' => ['Bloody Fantasy inc.']]],
        ]];

        $this->assertEquals($expectedArray, $array);
    }

    /**
     * @test
     */
    public function it_can_handle_multiple_includes_at_once()
    {
        $array = $this->fractal
            ->collection($this->testBooks, new TestTransformer())
            ->parseIncludes('characters, publisher')
            ->toArray();

        $expectedArray = ['data' => [
            ['id' => 1, 'author' => 'Philip K Dick',
                'characters' => ['data' => ['Death', 'Hex']],
                'publisher' => ['data' => ['Elephant books']],
            ],
            ['id' => 2, 'author' => 'George R. R. Satan',
                'characters' => ['data' => ['Ned Stark', 'Tywin Lannister']],
                'publisher' => ['data' => ['Bloody Fantasy inc.']],
            ],
        ]];

        $this->assertEquals($expectedArray, $array);
    }

    /**
     * @test
     */
    public function it_knows_to_ignore_invalid_includes_param()
    {
        $array = $this->fractal
            ->collection($this->testBooks, new TestTransformer())
            ->parseIncludes(null)
            ->toArray();

        $expectedArray = ['data' => [
            ['id' => 1, 'author' => 'Philip K Dick'],
            ['id' => 2, 'author' => 'George R. R. Satan'],
        ]];

        $this->assertEquals($expectedArray, $array);

        $array = $this->fractal
            ->collection($this->testBooks, new TestTransformer())
            ->parseIncludes([])
            ->toArray();
        $this->assertEquals($expectedArray, $array);
    }
}
