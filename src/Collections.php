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

    public function toArray() : array
    {
        return array_values($this->array);
    }
}