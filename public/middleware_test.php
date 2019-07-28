<?php
require __DIR__."/../vendor/autoload.php";
use tcb\Classes\Middleware;


$middleware = new Middleware(
    function ($reguest ,$next)
    {
        echo $reguest.PHP_EOL;
        return $next($reguest);
    }
);

$middleware->addNext(function ($reguest ,$next)
{
    echo $reguest.PHP_EOL;
    return $next($reguest);
})->addNext(function ($reguest ,$next)
{
    echo $reguest.PHP_EOL;

})->addNext(function ($reguest ,$next)
{
    echo $reguest.PHP_EOL;

});


Middleware::createChain("chain",$middleware);

echo Middleware::getChain()["chain"]("hello");