<?php


namespace Codesai\Collections;


final class InfiniteCollection implements \ArrayAccess
{
    /** @var callable */
    private $generator;

    public static function from(callable $param): InfiniteCollection
    {
        $collections = new InfiniteCollection();
        $collections->generator = fn(int $value, int $index) => $param($index);
        return $collections;
    }

    public function take(int $size) : Collection
    {
        $array = array_fill(0, $size, 0);
        return Collection::from($array)->map($this->generator);
    }

    public function __toString()
    {
        $parseToKeyAndValue = fn($value, $index) => "\t$index => $value";
        $splitKeysAndValues = implode(",\n", array_map($parseToKeyAndValue, $this->array, array_keys($this->array)));
        return "[\n$splitKeysAndValues\n]";
    }

    public function offsetExists($offset)
    {
        return false;
    }

    public function offsetGet($offset)
    {
        if (!is_integer($offset)) throw new \InvalidArgumentException();
        return $this->take($offset + 1)[$offset];
    }

    public function offsetSet($offset, $value)
    {
    }

    public function offsetUnset($offset)
    {
    }
}