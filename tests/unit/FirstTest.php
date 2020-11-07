<?php


namespace tests\unit;


use Codesai\Collections\Collection;
use PHPUnit\Framework\TestCase;

class FirstTest extends TestCase
{
    /** @test */
    public function should_return_the_first_element_from_an_array() {
        $collection = Collection::from([100, 'a', true]);

        $result = $collection->first();

        $this->assertEquals(100, $result);
    }

    /** @test */
    public function should_return_the_first_element_from_a_map() {
        $collection = Collection::from(['key_1' => 100, 'key_2' => 'a', 'key_3' => true]);

        $result = $collection->first();

        $this->assertEquals(100, $result);
    }



}