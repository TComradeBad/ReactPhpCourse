<?php

require __DIR__ . "/../vendor/autoload.php";

\tcb\Classes\Initializer::InitAll($url,"public");

require __DIR__ . "/../Routes/Routes.php";

$loop = \React\EventLoop\Factory::create();

$server = new \React\Http\Server(function (\Psr\Http\Message\ServerRequestInterface $request) use ($dispatcher) {
    $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());
    switch ($routeInfo[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:
            return new \React\Http\Response(404);
        case FastRoute\Dispatcher::FOUND:
            return $routeInfo[1]($request, ...array_values($routeInfo[2]));
    }
});

$socket = new \React\Socket\Server($url, $loop);

$server->listen($socket);
$loop->run();

