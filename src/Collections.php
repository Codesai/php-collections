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
        return new Collections(array_map($lambda, $this->array));
    }

    public function toArray() : array
    {
        return $this->array;
    }
}