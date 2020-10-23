<?php

namespace tests\unit;

use Codesai\Collections\Collection;
use PHPUnit\Framework\TestCase;

final class CollectionTest extends TestCase
{
    /**
     * TODO:
     *  - flatten
     *  - flatMap
     *  - next
     *  - reduce
     *  - all
     *  - any
     *  - forEach
     *  - first
     *  - group_by
     *  - reverse
     *  - sort
     *  - filter_null
     */

    /** @test */
    public function prints_a_collection()
    {
        self::assertEquals("[\n\t0 => 1,\n\t1 => 2,\n\t2 => 3\n]", strval(Collection::from([1, 2, 3])));
    }

    /** @test */
    public function retrieves_a_value_from_it_using_the_invoke_magic_method()
    {
        $collection = Collection::from([100, 'a', true]);

        $this->assertEquals(100, $collection(0));
        $this->assertEquals('a', $collection(1));
        $this->assertEquals(true, $collection(2));
    }

}