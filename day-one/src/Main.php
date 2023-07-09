<?php

namespace AOC\DayOne;

use AOC\DayOne\Observer\File;
use AOC\DayOne\Observer\FileEvents;
use AOC\DayOne\Observer\Observer;

class TopThree
{
    public array $three = [0, 0, 0];

    public function __construct()
    {
    }

    public function push(int $number)
    {
        if ($number > $this->three[0]) {
            $this->three[2] = $this->three[1]; // second item to third index
            $this->three[1] = $this->three[0]; // first item to second index
            $this->three[0] = $number; // new item to highest index

            return;
        }
        if ($number > $this->three[1]) {
            $this->three[2] = $this->three[1]; // second item to third index
            $this->three[1] = $number; // item to second index

            return;
        }
        if ($number > $this->three[2]) {
            $this->three[2] = $number; // item to last index

            return;
        }
    }
}

function formatBytes($bytes)
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];

    $index = 0;
    while ($bytes >= 1024 && $index < count($units) - 1) {
        $bytes /= 1024;
        $index++;
    }

    return round($bytes, 8).' '.$units[$index];
}

class Main
{
    public static function run()
    {
        $start = microtime(true);
        $accumulator = 0;
        $topThree = new TopThree();

        File::from('./input.txt')
            ->listen(FileEvents::Line, Observer::from(function (string $line) use (&$accumulator) {
                $accumulator = $accumulator + intval($line);
            }))
            ->listen(FileEvents::EmptyLine, Observer::from(function () use (&$accumulator, &$elfs, &$topThree) {
                $topThree->push($accumulator);
                $accumulator = 0;
            }))
            ->listen(FileEvents::End, Observer::from(function () use (&$topThree, &$start) {
                $end = microtime(true);
                $time = $end - $start;
                $bytes = formatBytes(memory_get_peak_usage());

                echo 'Top 1: '.$topThree->three[0]."\n";
                echo 'Total of Top 3: '.$topThree->three[0] + $topThree->three[1] + $topThree->three[2]."\n";
                echo "Execution start: {$start}\n";
                echo "Execution end: {$end}\n";
                echo "Execution time in seconds: {$time}\n";
                echo "Memory Usage: {$bytes}\n";
            }))
            ->read();
    }
}

Main::run();
