<?php


require './vendor/autoload.php';


$loop = React\EventLoop\Factory::create();

$loop->addTimer(1, function () {
    echo "After Timer \n";
});

echo "before Timer \n";


$loop->run();
