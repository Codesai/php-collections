<?php

namespace tests\unit;

use Codesai\Collections\Collection;
use Codesai\Collections\exceptions\InfiniteCollectionValuesNotBounded;
use PHPUnit\Framework\TestCase;

final class CollectionsTest extends TestCase
{

    /** @test */
    public function prints_a_collection()
    {
        self::assertEquals("[\n\t0 => 1,\n\t1 => 2,\n\t2 => 3\n]", strval(Collection::from([1, 2, 3])));
    }

    /** @test
     * @throws InfiniteCollectionValuesNotBounded
     */
    public function filter_values_of_an_array_collection_for_a_given_lambda()
    {
        $givenCollection = Collection::from([1, 2, 3, 4, 5, 6]);

        $result = $givenCollection->filter(fn(int $value)  => $value % 2 == 0)->toList();

        self::assertEquals([0 => 2, 1 => 4, 2 => 6], $result);
    }

    /** @test
     * @throws InfiniteCollectionValuesNotBounded
     */
    public function filter_values_of_a_map_collection_for_a_given_lambda()
    {
        $givenCollection = Collection::from(['parrot' => 1, 'cockatoo' => 2, 'african_grey' => 3]);

        $result = $givenCollection->filter(fn(int $value) => $value % 2 == 0)->toDictionary();

        self::assertEquals(['cockatoo' => 2], $result);
    }

    /** @test
     * @throws InfiniteCollectionValuesNotBounded
     */
    public function applies_a_lambda_to_the_array_collection_with_many_values()
    {
        $givenCollection = Collection::from([1, 2, 3, 4]);

        $result = $givenCollection->map(fn(int $number) => $number + 2)->toList();

        self::assertEquals([0 => 3, 1 => 4, 2 => 5, 3 => 6], $result);
    }

    /** @test
     * @throws InfiniteCollectionValuesNotBounded
     */
    public function applies_a_lambda_to_the_array_collection_with_many_values_using_the_value_position_in_the_array()
    {
        $givenCollection = Collection::from([1, 2, 3, 4]);

        $result = $givenCollection->map(fn(int $value, int $index) => $value + $index);

        self::assertEquals(Collection::from([1, 3, 5, 7]), $result);
    }

    /** @test
     * @throws InfiniteCollectionValuesNotBounded
     */
    public function create_an_infinite_collection_generated_from_a_lambda()
    {
        $givenCollection = Collection::from(fn(int $index) => $index);

        $result = $givenCollection
            ->take(3)
            ->map(fn(int $value, int $index) => $value + 2);

        self::assertEquals(Collection::from([2, 3, 4]), $result);
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