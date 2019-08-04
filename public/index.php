<?php

require __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::create(__DIR__ . "/../configs/ENV/", "databaseConfig.env");
$dotenv->overload();

\tcb\Classes\DatabaseService::initOptions(include __DIR__ . "/../configs/databaseConfig.php");
\tcb\Classes\FileSystem::initDirectories(include __DIR__ . "/../configs/directoryConfig.php");

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

$socket = new \React\Socket\Server("192.168.33.10:8080", $loop);

$server->listen($socket);
$loop->run();

