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

    public function infiniteCollectionsNotBounded()
    {
        return [
            [fn() => Collection::from(fn(int $index) => $index)->map(fn(int $value, int $index) => $value + 2)],
            [fn() => Collection::from(fn(int $index) => $index)->filter(fn(int $value, int $index) => $index % 2 == 0)]
        ];
    }
}