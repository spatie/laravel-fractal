<?php

namespace Spatie\Fractal\Test\Integration;

use Spatie\Fractal\ArraySerializer;
use Spatie\Fractal\Exceptions\InvalidUseOfFractalHelper;
use Spatie\Fractal\Fractal;

class FractalFunctionHelperTest extends TestCase
{
    /** @test */
    public function it_returns_an_instance_of_fractal_when_passing_no_arguments()
    {
        $this->assertInstanceOf(Fractal::class, fractal());
    }

    /** @test */
    public function it_throws_an_exception_when_passing_one_argument()
    {
        $this->expectException(InvalidUseOfFractalHelper::class);

        fractal([]);
    }

    /** @test */
    public function it_can_transform_the_given_array_with_the_given_closure()
    {
        $transformedData = fractal(['item1', 'item2'], function ($item) {
            return $item.'-transformed';
        })->toArray();

        $this->assertEquals([
            'data' => ['item1-transformed', 'item2-transformed'],
        ], $transformedData);
    }

    /** @test */
    public function it_can_transform_the_given_item_with_the_given_closure()
    {
        $item = new \stdClass();
        $item->name = 'item1';

        $transformedData = fractal($item, function ($item) {
            return ["{$item->name}-transformed"];
        })->toArray();

        $this->assertEquals([
            'data' => ['item1-transformed'],
        ], $transformedData);
    }

    /** @test */
    public function it_can_transform_the_given_array_with_the_given_transformer()
    {
        $transformedData = fractal($this->testBooks, new TestTransformer())->toArray();

        $expectedArray = ['data' => [
            ['id' => 1, 'author' => 'Philip K Dick'],
            ['id' => 2, 'author' => 'George R. R. Satan'],
        ]];

        $this->assertEquals($expectedArray, $transformedData);
    }

    /** @test */
    public function it_can_transform_the_given_traversable_with_the_given_transformer()
    {
        $transformedData = fractal(collect($this->testBooks), new TestTransformer())->toArray();

        $expectedArray = ['data' => [
            ['id' => 1, 'author' => 'Philip K Dick'],
            ['id' => 2, 'author' => 'George R. R. Satan'],
        ]];

        $this->assertEquals($expectedArray, $transformedData);
    }

    /** @test */
    public function it_perform_a_transformation_with_the_given_serializer()
    {
        $transformedData = fractal(
            collect($this->testBooks),
            new TestTransformer(),
            new ArraySerializer()
        )->toArray();

        $expectedArray = [
            ['id' => 1, 'author' => 'Philip K Dick'],
            ['id' => 2, 'author' => 'George R. R. Satan'],
        ];

        $this->assertEquals($expectedArray, $transformedData);
    }

    /** @test */
    public function it_will_thrown_an_exception_when_passing_too_many_arguments()
    {
        $this->expectException(InvalidUseOfFractalHelper::class);

        fractal(
            collect($this->testBooks),
            new TestTransformer(),
            new ArraySerializer(),
            'extra argument'
        )->toArray();
    }
}
