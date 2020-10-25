<?php


namespace Codesai\Collections;


use ArrayAccess;

final class Collection implements ArrayAccess, \Iterator
{
    private array $array;
    private int $position = 0;

    public static function from(array $array): Collection
    {
        return new Collection($array);
    }

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function map(callable $lambda) : Collection
    {
        return static::from(array_map($lambda, $this->array, array_keys($this->array)));
    }

    public function filter(callable $lambda)
    {
        return static::from(array_filter($this->array, $lambda));
    }

    public function take(int $size)
    {
        return static::from(array_chunk($this->array, $size));
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

    /**
     * @param mixed $key
     * @param mixed $value
     * @return Collection
     */
    public function set($key, $value) : Collection
    {
        $clone = array_merge([], $this->array);
        $clone[$key] = $value;
        return Collection::from($clone);
    }
}