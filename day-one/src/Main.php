<?php
namespace Adam\DayOne;

use Adam\DayOne\Observer\File;
use Adam\DayOne\Observer\FileEvents;
use Adam\DayOne\Observer\Observer;

class Main
{
  public static function run() {
    $start = microtime(true);
    $accumulator = [];
    $elfs = [];

    File::from("./input.txt")
      ->listen(FileEvents::Line, Observer::from(function (string $line) use (&$accumulator) {
          $newLine = trim($line);
          array_push($accumulator, $newLine);
        }))
      ->listen(FileEvents::Empty, Observer::from(function () use (&$accumulator, &$elfs) {
        array_push($elfs, new Elf($accumulator));
        $accumulator = [];
      }))
      ->listen(FileEvents::End, Observer::from(function () use (&$elfs, &$start) {
          $arr = array_map(function(Elf $elf) {
            return $elf->total();
          }, $elfs);
          rsort($arr);
          $end = microtime(true);
          $time = $end - $start;

          print("Top 1: " . $arr[0] . "\n");
          print("Top 3: " . $arr[0] + $arr[1] + $arr[2] . "\n");
          print("Execution start: {$start}\n");
          print("Execution end: {$end}\n");
          print("Execution time: {$time}");
        }))
        ->read();
  }
}

Main::run();
