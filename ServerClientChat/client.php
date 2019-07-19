<?php

require "/var/www/ReactPhpProject/ReactPhpCourse/vendor/autoload.php";

$loop = React\EventLoop\Factory::create();
$input = new React\Stream\ReadableResourceStream(STDIN,$loop);
$output = new \React\Stream\WritableResourceStream(STDOUT,$loop);
$connector = new \React\Socket\Connector($loop);

$connector->connect("192.168.33.10:8080")
->then(function (\React\Socket\ConnectionInterface $connection) use ($input,$output){
    $connection->pipe($output);
    $input->pipe($connection);
},function (Exception $exception){
    echo $exception->getMessage();
});

$loop->run();