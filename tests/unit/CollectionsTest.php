<?php

namespace tests\unit;

use Codesai\Collections\Collections;
use PHPUnit\Framework\TestCase;

final class CollectionsTest extends TestCase
{

    /** @test */
    public function applies_a_lambda_to_the_array_collection_with_a_single_value()
    {
        $givenCollection = Collections::stream([1]);

        $result = $givenCollection->map(function(int $number) {
            return $number + 2;
        })->toArray();

        self::assertEquals([0 => 3], $result);
    }

    /** @test */
    public function applies_a_lambda_to_the_array_collection_with_many_values()
    {
        $givenCollection = Collections::stream([1, 2, 3, 4]);

        $result = $givenCollection->map(function(int $number) {
            return $number + 2;
        })->toArray();

        self::assertEquals([0 => 3, 1 => 4, 2 => 5, 3 => 6], $result);
    }

}