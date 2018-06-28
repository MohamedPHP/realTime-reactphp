<?php


require './vendor/autoload.php';


$loop = \React\EventLoop\Factory::create();

$readable = new \React\Stream\ReadableResourceStream(STDIN, $loop, 1);

$readable->on('data', function ($chunk) use ($readable, $loop) {
    $readable->pause();

    echo $chunk . PHP_EOL;

    $loop->addTimer(2, function () use ($readable) {
        $readable->resume();
    });
});

$readable->on('end', function () {
    echo "The File Has Ended" . PHP_EOL;
});

$loop->run();
