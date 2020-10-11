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

    public function map(\Closure $lambda) : Collections
    {

        return new Collections(array_map($lambda, $this->array, array_keys($this->array)));
    }

    public function filter(\Closure $lambda)
    {
        return new Collections(array_filter($this->array, $lambda));
    }

    public function toList() : array
    {
        return array_values($this->array);
    }

    public function __toString()
    {
        $splitKeysAndValues = implode(", ", $this->mapKeysAndValues());
        return "[$splitKeysAndValues]";
    }

    /** @return string[] */
    public function mapKeysAndValues(): array
    {
        return array_map(function ($value, $index) {
            return "$index => $value";
        }, $this->array, array_keys($this->array));
    }

    public function toDictionary()
    {
        return $this->array;
    }
}