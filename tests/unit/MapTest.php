<?php


namespace tests\unit;


use Codesai\Collections\Collection;
use Codesai\Collections\exceptions\InfiniteCollectionValuesNotBounded;
use PHPUnit\Framework\TestCase;

class MapTest extends TestCase
{
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
}