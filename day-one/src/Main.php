<?php
namespace Adam\DayOne;

use Adam\DayOne\File;

class Main
{
  public static function run() {
    $start = microtime(true);
    $accumulator = [];
    $elfs = [];

    File::from('./input.txt')
    ->onLine(function (string $line) use (&$accumulator, &$elfs) {
      $newLine = trim($line);

      if (File::isLineEmpty($newLine)) {
        array_push($elfs, new Elf($accumulator));
        $accumulator = [];
      } else {
        array_push($accumulator, $newLine);
      }
    })
    ->onEnd(function () use (&$elfs, &$start) {
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
    })
    ->read();
  }
}

Main::run();
