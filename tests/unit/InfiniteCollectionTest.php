<?php


namespace tests\unit;


use Codesai\Collections\InfiniteCollection;
use PHPUnit\Framework\TestCase;

class InfiniteCollectionTest extends TestCase
{

    /** @test */
    public function prints_an_infinite_collection()
    {
        $this->assertEquals("[\n\t0 => a0,\n\t1 => a1,\n\t2 => a2,\n\t3 => a3,\n\t4 => a4,\n\t5 => a5,\n\t6 => a6,\n\t7 => a7,\n\t8 => a8,\n\t9 => a9,\n\t10 => a10,\n\t...\n]",
            strval(InfiniteCollection::from(fn($index) => "a$index")));
    }

    /** @test */
    public function create_an_infinite_collection_generated_from_a_lambda()
    {
        $givenCollection = InfiniteCollection::from(fn(int $index) => $index);

        $result = $givenCollection
            ->take(3)
            ->toList();

        self::assertEquals([0, 1, 2], $result);
    }

    /** @test
     */
    public function retrieves_a_value_from_it_using_the_invoke_magic_method()
    {
        $collection = InfiniteCollection::from(fn($index) => $index + 1);

        $this->assertEquals(1, $collection[0]);
        $this->assertEquals(101, $collection[100]);
    }

    /** @test
     * @dataProvider invalidInfiniteCollectionKeys
     * @param $invalidKey
     */
    public function cannot_retrieve_a_value_when_the_key_is_not_a_number($invalidKey)
    {
        $this->expectException('InvalidArgumentException');

        $collection = InfiniteCollection::from(fn($index) => $index + 1);

        $collection[$invalidKey];
    }

    public function invalidInfiniteCollectionKeys()
    {
        return [
            ['invalid'],
            [true],
            [[]],
            [10.5],
            [null],
            [new class {}]
        ];
    }
}