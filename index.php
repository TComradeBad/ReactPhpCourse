<?php

define("directory","/var/www/ReactPhpProject/ReactPhpCourse");
require directory."/vendor/autoload.php";
require directory."/Routes/Routes.php";

$loop = \React\EventLoop\Factory::create();


$server = new \React\Http\Server(function (\Psr\Http\Message\ServerRequestInterface $request) use ($dispatcher){
    $routeInfo = $dispatcher->dispatch($request->getMethod(),$request->getUri()->getPath());
    switch ($routeInfo[0]){
        case FastRoute\Dispatcher::NOT_FOUND:
            return new \React\Http\Response(404);
        case FastRoute\Dispatcher::FOUND:
            return $routeInfo[1]($request);
    }
});


$socket = new \React\Socket\Server("192.168.33.10:8080",$loop);

$server->listen($socket);
$loop->run();

