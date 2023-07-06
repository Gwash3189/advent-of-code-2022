<?php

namespace AOC\DayOne\Observer;

class Observer
{
    public static function from($callback): Observer
    {
        return new Observer($callback);
    }

    public function __construct(private $callback)
    {
    }

    public function update($data): mixed
    {
        return call_user_func($this->callback, $data);
    }
}
