<?php

use AOC\DayOne\Observer\Observer;
use AOC\DayOne\Observer\Subject;
use Mockery;

afterEach(function () {
    Mockery::close();
});

it('returns the Subject when subscribing')
    ->expect(new Subject())
    ->subscribe('event', Observer::from(function () {
        echo 'Hello';
    }))
    ->toBeInstanceOf(Subject::class);

it('notifys all observers of an event type', function () {
    $arg = [];
    $observer = Mockery::mock(Observer::class);

    $observer->shouldReceive('update')->with($arg)->once();

    $subject = new Subject();
    $subject->subscribe('event', $observer)->notify('event', $arg);
});

it('when there are multiple observers for a single event type, it calls each of them', function () {
    $arg = [];
    $observerOne = Mockery::mock(Observer::class);
    $observerTwo = Mockery::mock(Observer::class);

    $observerOne->shouldReceive('update')->with($arg)->once();
    $observerTwo->shouldReceive('update')->with($arg)->once();

    $subject = new Subject();
    $subject
        ->subscribe('event', $observerOne)
        ->subscribe('event', $observerTwo)
        ->notify('event', $arg);
});
