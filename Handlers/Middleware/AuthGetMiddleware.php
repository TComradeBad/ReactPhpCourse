<?php

use tcb\Classes\MiddlewareFactory;
$middleware = new MiddlewareFactory();

$middleware->addFunction(
    function (\Psr\Http\Message\ServerRequestInterface $request,$next,$name)
    {
        $cookie = $request->getCookieParams();
        if(!isset($cookie["username"]) or $cookie["username"] != $name)
        {
            return new \React\Http\Response(404);
        }else return $next($request);
    }
);
$middleware->defineFunctionChain("auth-get");