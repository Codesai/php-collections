<?php


namespace tests\unit;


use Codesai\Collections\Collection;
use Codesai\Collections\exceptions\InfiniteCollectionValuesNotBounded;
use PHPUnit\Framework\TestCase;

class InfiniteCollectionTest extends TestCase
{

    /** @test */
    public function create_an_infinite_collection_generated_from_a_lambda()
    {
        $givenCollection = Collection::from(fn(int $index) => $index);

        $result = $givenCollection
            ->take(3)
            ->toList();

        self::assertEquals([0, 1, 2], $result);
    }

    /**
     * @test
     * @dataProvider infiniteCollectionsNotBounded
     * @param callable $infiniteCollectionLambda
     */
    public function when_infinite_collection_values_are_not_bounded_an_exception_raises(callable $infiniteCollectionLambda)
    {
        $this->expectException(InfiniteCollectionValuesNotBounded::class);

        $infiniteCollectionLambda();
    }

    /** @test
     */
    public function retrieves_a_value_from_it_using_the_invoke_magic_method()
    {
        $collection = Collection::from(fn($index) => $index + 1);

        $this->assertEquals(1, $collection[0]);
        $this->assertEquals(101, $collection[100]);
    }

    /** @test
     * @dataProvider invalidInfiniteCollectionKeys
     * @param $invalidKey
     */
    public function cannot_retrieve_a_value_when_the_key_is_not_a_number($invalidKey)
    {
        $this->expectException('InvalidArgumentException');

        $collection = Collection::from(fn($index) => $index + 1);

        $collection[$invalidKey];
    }

    public function infiniteCollectionsNotBounded()
    {
        return [
            [fn() => Collection::from(fn(int $index) => $index)->map(fn(int $value, int $index) => $value + 2)],
            [fn() => Collection::from(fn(int $index) => $index)->filter(fn(int $value, int $index) => $index % 2 == 0)]
        ];
    }

    public function invalidInfiniteCollectionKeys()
    {
        return [
            ['invalid'],
            [true],
            [[]],
            [10.5],
            [null],
            [new class {}]
        ];
    }
}