<?php

require 'vendor/autoload.php';


$loop = \React\EventLoop\Factory::create();

$readable = new \React\Stream\ReadableResourceStream(STDIN, $loop);

$writable = new \React\Stream\WritableResourceStream(STDOUT, $loop);

$toUpper = new \React\Stream\ThroughStream(function ($chunk) {
    return strtoupper($chunk);
});

// instead of using this way i can use the pipe method

//$readable->on('data', function ($ch) use($writable) {
//    $writable->write($ch);
//});

$readable->pipe($toUpper)->pipe($writable);



$loop->run();
