<?php


require 'vendor/autoload.php';

use React\Socket\ConnectionInterface;
use React\EventLoop\Factory;
use React\Stream\ReadableResourceStream;
use React\Stream\WritableResourceStream;
use React\Socket\Connector;

$loop = Factory::create();

$readable = new ReadableResourceStream(STDIN, $loop);
$writable = new WritableResourceStream(STDOUT, $loop);

$connector = new Connector($loop);

$connector->connect('127.0.0.1:8000')
          ->then(function (ConnectionInterface $connection) use($readable, $writable) {
              $readable->pipe($connection)->pipe($writable);
          }, function (Exception $e) {
              echo $e->getMessage() . PHP_EOL;
          });

$loop->run();