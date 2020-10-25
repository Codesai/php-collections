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
    public function set_a_value_on_the_collection_using_php_array_set_syntax_but_creating_a_new_collection_not_mutating_the_current_one()
    {
        $collection = Collection::from([100, 'a', true]);

        $wtf = $collection[1] = 'b';

        var_dump($wtf);

        $this->assertEquals('a', $collection[1]);
        $this->assertEquals('b', $wtf[1]);
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