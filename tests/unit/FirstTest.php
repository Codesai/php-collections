<?php


namespace tests\unit;


use Codesai\Collections\Collection;
use Codesai\Collections\InfiniteCollection;
use PHPUnit\Framework\TestCase;

class FirstTest extends TestCase
{
    /** @test */
    public function should_return_the_first_element_from_an_array_collection() {
        $collection = Collection::from([100, 'a', true]);

        $result = $collection->first();

        $this->assertEquals(100, $result);
    }

    /** @test */
    public function should_return_the_first_element_from_a_dictionary_collection() {
        $collection = Collection::from(['key_1' => 100, 'key_2' => 'a', 'key_3' => true]);

        $result = $collection->first();

        $this->assertEquals(100, $result);
    }

    /** @test */
    public function should_return_the_first_element_from_a_infinite_collection() {
        $collection = InfiniteCollection::from(fn($index) => 'a');

        $result = $collection->first();

        $this->assertEquals('a', $result);
    }

}