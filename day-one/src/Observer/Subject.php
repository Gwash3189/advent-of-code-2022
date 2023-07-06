<?php

namespace AOC\DayOne\Observer;

class Subject
{
    private $observers;

    public function __construct()
    {
        $this->observers = [];
    }

    public function subscribe(string $eventType, Observer $observer): Subject
    {
        $observers = $this->observers[$eventType] ?? [];

        $this->observers[$eventType] = [...$observers, $observer];

        return $this;
    }

    public function notify(string $eventType, mixed $data)
    {
        foreach ($this->observers[$eventType] as $observer) {
            $observer->update($data);
        }
    }
}
