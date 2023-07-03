<?php
namespace Adam\DayOne;


class Elf
{
  public function __construct(public readonly array $calories) {}

  public function total(): int {
    return array_reduce($this->calories, function (int $total, string $calorie): int {
      return $total + intval($calorie);
    }, 0);
  }
}
