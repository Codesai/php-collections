<?php


namespace Codesai\Collections;


use Codesai\Collections\exceptions\InfiniteCollectionValuesNotBounded;

final class Collections
{
    private array $array;
    /**
     * @var callable
     */
    private $generator;

    /**
     * @param array|callable $param
     * @return Collections
     */
    public static function stream($param): Collections
    {
        if ($param instanceof \Closure) return static::infiniteCollection($param);
        return static::arrayCollection($param);
    }

    private static function arrayCollection(array $array)
    {
        $collections = new Collections();
        $collections->array = $array;
        return $collections;
    }

    private static function infiniteCollection(callable $lambda)
    {
        $collections = new Collections();
        $collections->generator = fn(int $value, int $index) => $lambda($index);
        return $collections;
    }

    public function map(callable $lambda) : Collections
    {
        if ($this->generator) throw new InfiniteCollectionValuesNotBounded();
        return static::arrayCollection(array_map($lambda, $this->array, array_keys($this->array)));
    }

    public function filter(callable $lambda)
    {
        return static::arrayCollection(array_filter($this->array, $lambda));
    }

    public function toList() : array
    {
        return array_values($this->array);
    }

    public function toDictionary()
    {
        return $this->array;
    }

    public function __toString()
    {
        $parseToKeyAndValue = fn($value, $index) => "\t$index => $value";
        $splitKeysAndValues = implode(",\n", array_map($parseToKeyAndValue, $this->array, array_keys($this->array)));
        return "[\n$splitKeysAndValues\n]";
    }

    public function take(int $size)
    {
        $array = array_fill(0, $size, 0);
        return static::arrayCollection($array)->map($this->generator);
    }
}