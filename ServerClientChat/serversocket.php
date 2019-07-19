<?php

require "/var/www/ReactPhpProject/ReactPhpCourse/vendor/autoload.php";

$connections = new SplObjectStorage();

$loop = React\EventLoop\Factory::create();

$server = new \React\Socket\Server("192.168.33.10:8080",$loop);

$pool = new \tcb\Classes\ConnectionPool();

$server->on("connection",function (\React\Socket\ConnectionInterface $connection) use ($pool)
{
    $pool->addConnection($connection);
});

$loop->run();


