<?php
namespace Adam\DayOne\Observer;

use Generator;
use RuntimeException;

enum FileEvents
{
  case Line;
  case Empty;
  case End;

  public function event(): string
  {
    return match($this)
    {
      FileEvents::Line => 'line',
      FileEvents::Empty => 'empty',
      FileEvents::End => 'end',
    };
  }
}

class File extends Subject
{
  public static function from(string $path) {
    return new self($path);
  }

  public function __construct(private readonly string $path) {
    parent::__construct();
  }

  public function listen(FileEvents $eventType, Observer $observer): File
  {
    parent::subscribe($eventType->event(), $observer);
    return $this;
  }

  public function read(): void {
    $lines = $this->start();

    foreach ($lines as $line) {
      $trimmed = trim($line);

      if(empty($trimmed)) {
        $this->notify(FileEvents::Empty->event());
      } else {
        $this->notify(FileEvents::Line->event());
      }
    }

    $this->notify(FileEvents::End->event());
  }

  private function start(): Generator {
    $handle = fopen($this->path, 'r');

    if ($handle === false) {
        throw new RuntimeException("Cannot open file: {$this->path}");
    }

    while (($line = fgets($handle)) !== false) {
        yield $line;
    }

    fclose($handle);
  }
}
