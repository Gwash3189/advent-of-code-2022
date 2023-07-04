<?php
namespace Adam\DayOne\Observer;

class Subject
{
  private $observers;

  public function __construct() {
    $this->observers = [];
  }

  public function subscribe(string $eventType, Observer $observer): Subject {
    $observers = $this->observers[$eventType];

    if (empty($observers)) {
      $this->observers[$eventType] = [$observer];
    } else {
      $arr = $this->observers[$eventType];
      $arr[] = $observer;
      $this->observers[$eventType] = $arr;
    }

    return $this;
  }

  public function notify(string $eventType) {
    foreach ($this->observers[$eventType] as $observer) {
      $observer->update();
    }
  }
}

