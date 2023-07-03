<?php
namespace Adam\DayOne;

use RuntimeException;

class File
{
    private string $filePath;
    private $onLine;
    private $onEnd;

    private function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public static function trim(string $line): bool {
        return trim($line);
    }

    public static function isLineEmpty(string $line): bool {
        return strlen($line) === 0;
    }

    public static function from(string $filePath): self
    {
        return new self($filePath);
    }

    public function onLine(callable $onLine): self
    {
        $this->onLine = $onLine;
        return $this;
    }

    public function onEnd(callable $callback): self
    {
        $this->onEnd = $callback;
        return $this;
    }

    public function read(): mixed
    {
        $handle = fopen($this->filePath, 'r');
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                call_user_func($this->onLine, $line);
            }
            $result = call_user_func($this->onEnd, $line);
            fclose($handle);
            return $result;
        } else {
            throw new RuntimeException("Cannot open file: {$this->filePath}");
        }
    }
}
