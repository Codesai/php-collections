<?php


namespace Codesai\Collections;


use Codesai\Collections\exceptions\InfiniteCollectionValuesNotBounded;

final class Collection
{
    private array $array;
    /** @var callable */
    private $generator;

    /**
     * @param array|callable $param
     * @return Collection
     */
    public static function from($param): Collection
    {
        if (is_callable($param)) return static::infiniteCollection($param);
        return static::arrayCollection($param);
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function __invoke($key)
    {
        return $this->array[$key];
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
}