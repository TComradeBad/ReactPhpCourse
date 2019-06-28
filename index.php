<?php

require __DIR__.'\vendor\autoload.php';


$loop = React\EventLoop\Factory::create();
$fs = React\Filesystem\Filesystem::create($loop);



