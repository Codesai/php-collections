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
     *  - last
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
    public function gets_a_value_using_php_array_access_syntax()
    {
        $collection = Collection::from([100, 'a', true]);

        $this->assertEquals(100, $collection[0]);
        $this->assertEquals('a', $collection[1]);
        $this->assertEquals(true, $collection[2]);
    }


    /** @test */
    public function set_a_value_on_the_collection_using_php_array_set_syntax()
    {
        $collection = Collection::from([100, 'a', true]);

        $collection[1] = 'b';

        $this->assertEquals('b', $collection[1]);
    }

    /** @test */
    public function add_a_value_on_the_collection_at_tail_when_not_specifying_offset_on_php_array_set_syntax()
    {
        $collection = Collection::from([100, 'a', true]);

        $collection[] = 'b';

        $this->assertEquals(Collection::from([100, 'a', true, 'b']), $collection);
    }

    /** @test */
    public function can_foreach_a_collection_like_a_php_array()
    {
        $collection = Collection::from([100, 'a', true]);

        $result = [];
        foreach ($collection as $item) {
            $result[] = $item;
        }

        $this->assertEquals([100, 'a', true], $result);

        $result = [];
        foreach ($collection as $item) {
            $result[] = $item;
        }

        $this->assertEquals([100, 'a', true], $result);
    }

}