<?php

use tcb\Classes\MiddlewareFactory;

$middleware = new MiddlewareFactory();

$middleware->addFunction(
    function (\Psr\Http\Message\ServerRequestInterface $request, $next, $name) {
        $name = str_replace("_", " ", $name);
        $user = new \tcb\Classes\User($name, null, null);
        if ($user->nameNotExistInDB()) {
            return new \React\Http\Response(404);
        } else return $next($request);
    }
);
$middleware->defineFunctionChain("user-exist");