<?php

namespace AOC\DayOne;

class Elf
{
    public readonly int $total;

    public function __construct(array $calories)
    {
        $this->total = array_reduce(
            $calories,
            fn (int $total, string $calorie): int => $total + intval($calorie),
            0
        );
    }
}
