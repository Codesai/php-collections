<?php


namespace Codesai\Collections;


final class Collections
{
    private array $array;

    public static function stream(array $array): Collections
    {
        return new Collections($array);
    }

    private function __construct(array $array)
    {
        $this->array = $array;
    }

    public function map(callable $lambda) : Collections
    {

        return new Collections(array_map($lambda, $this->array, array_keys($this->array)));
    }

    public function filter(callable $lambda)
    {
        return new Collections(array_filter($this->array, $lambda));
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
}