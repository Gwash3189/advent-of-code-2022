<?php

use AOC\DayOne\Elf;

it('Elf\s store their calories')
    ->expect(new Elf(['1', '2', '3']))
    ->calories
    ->toContain('1', '2', '3');

it('Elf\s return the total of their calories')
    ->expect(new Elf(['1', '1']))
    ->total()
    ->toEqual(2);
