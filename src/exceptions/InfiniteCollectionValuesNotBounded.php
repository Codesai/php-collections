<?php


namespace Codesai\Collections\exceptions;


class InfiniteCollectionValuesNotBounded extends \Exception
{
    public function __construct()
    {
        parent::__construct("An infinite collection values should be bounded in order to apply any operation on the collection.");
    }

}