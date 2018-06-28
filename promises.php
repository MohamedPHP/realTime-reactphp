<?php

require 'vendor/autoload.php';

function http($url, $method)
{
    $response = false;

    $deferred = new \React\Promise\Deferred();

    if ($response) {
        $deferred->resolve($response);
    } else {
        $deferred->reject(new Exception("Error"));
    }

    return $deferred->promise();
}

http('https://www.google.com', 'GET')->then(function ($res) {
    echo $res . PHP_EOL;
}, function (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
});
