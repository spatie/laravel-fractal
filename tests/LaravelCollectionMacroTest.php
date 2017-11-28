<?php

namespace Spatie\Fractal\Test;

use Illuminate\Support\Collection;

class LaravelCollectionMacroTest extends TestCase
{
    /** @test */
    public function it_provides_laravel_colletion_macro()
    {
        $transformedData = Collection::make($this->testBooks)
            ->transformWith(new TestTransformer())
            ->toArray();

        $expectedArray = ['data' => [
            ['id' => 1, 'author' => 'Philip K Dick'],
            ['id' => 2, 'author' => 'George R. R. Satan'],
        ]];

        $this->assertEquals($expectedArray, $transformedData);
    }
}
