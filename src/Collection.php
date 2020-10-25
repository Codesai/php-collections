<?php


namespace Codesai\Collections;


use ArrayAccess;
use Codesai\Collections\exceptions\InfiniteCollectionValuesNotBounded;

final class Collection implements ArrayAccess, \Iterator
{
    private array $array;
    /** @var callable */
    private $generator;
    private $position = 0;

    /**
     * @param array|callable $param
     * @return Collection
     */
    public static function from($param): Collection
    {
        if (is_callable($param)) return static::infiniteCollection($param);
        return static::arrayCollection($param);
    }

    private static function arrayCollection(array $array)
    {
        $collections = new Collection();
        $collections->array = $array;
        return $collections;
    }

    private static function infiniteCollection(callable $lambda)
    {
        $collections = new Collection();
        $collections->generator = fn(int $value, int $index) => $lambda($index);
        return $collections;
    }

    /**
     * @param callable $lambda
     * @return Collection
     * @throws InfiniteCollectionValuesNotBounded
     */
    public function map(callable $lambda) : Collection
    {
        $this->validateInfiniteStream();
        return static::arrayCollection(array_map($lambda, $this->array, array_keys($this->array)));
    }

    /**
     * @param callable $lambda
     * @return Collection
     * @throws InfiniteCollectionValuesNotBounded
     */
    public function filter(callable $lambda)
    {
        $this->validateInfiniteStream();
        return static::arrayCollection(array_filter($this->array, $lambda));
    }

    public function take(int $size)
    {
        $array = array_fill(0, $size, 0);
        return static::arrayCollection($array)->map($this->generator);
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

    /**
     * @throws InfiniteCollectionValuesNotBounded
     */
    private function validateInfiniteStream(): void
    {
        if ($this->generator) throw new InfiniteCollectionValuesNotBounded();
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset) : bool
    {
        return array_key_exists($offset, $this->array);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->array[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (isset($offset)) {
            $this->array[$offset] = $value;
        } else {
            $this->array[] = $value;
        }
    }

    /** @param mixed $offset */
    public function offsetUnset($offset)
    {
        unset($this->array[$offset]);
    }

    public function current()
    {
        return $this->array[$this->position];
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return isset($this->array[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }
}