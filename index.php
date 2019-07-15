<?php

require __DIR__.'/vendor/autoload.php';


$loop = React\EventLoop\Factory::create();

$server = new React\Http\Server(function (Psr\Http\Message\ServerRequestInterface $request) {
    return new React\Http\Response(
        200,
        array('Content-Type' => 'text/plain'),
        "Hello World!\n"
    );
});

$socket = new React\Socket\Server("192.168.33.10:8080", $loop);
$server->listen($socket);

echo "SERVER RUN";
$loop->run();


