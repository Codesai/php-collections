<?php


namespace tests\unit;


use Codesai\Collections\Collection;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{

    /** @test */
    public function filter_values_of_an_array_collection_for_a_given_lambda()
    {
        $givenCollection = Collection::from([1, 2, 3, 4, 5, 6]);

        $result = $givenCollection->filter(fn(int $value)  => $value % 2 == 0)->toList();

        self::assertEquals([0 => 2, 1 => 4, 2 => 6], $result);
    }

    /** @test */
    public function filter_values_of_a_map_collection_for_a_given_lambda()
    {
        $givenCollection = Collection::from(['parrot' => 1, 'cockatoo' => 2, 'african_grey' => 3]);

        $result = $givenCollection->filter(fn(int $value) => $value % 2 == 0)->toDictionary();

        self::assertEquals(['cockatoo' => 2], $result);
    }

}