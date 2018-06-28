<?php


require './vendor/autoload.php';


$loop = React\EventLoop\Factory::create();

$counter = 0;

$timer = $loop->addPeriodicTimer(1, function () use (&$counter, &$timer, $loop) {
    $counter++;
    if ($counter > 5) {
        $loop->cancelTimer($timer);
        echo "The Timer Has Ended \n";
    } else {
        echo "Running ... \n";
    }
});

$loop->run();
