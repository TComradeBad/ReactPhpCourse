<?php

use tcb\Classes\Middleware;
use tcb\Classes\MiddlewareFactory;
$middleware = new MiddlewareFactory();
$middleware->addFunction(
    function (\Psr\Http\Message\ServerRequestInterface $request, $next)
    {
        $dir = new \tcb\Classes\FileSystem();
        $result = $request->getParsedBody();
        $user = new \tcb\Classes\User($result['username'],null,$result["password"]);

        if(($user->nameNotExistInDB()) or !($user->vertifyPassword()))
        {
            return new \React\Http\Response(200,["Content-Type" => "text/html"],
                $dir->page('redirect.html',
                    ["destination" => "http://192.168.33.10:8080/auth_error"]));
        }else return $next($request);
    });
$middleware = $middleware->createMiddlewareChain();

Middleware::defineChain("auth-post",$middleware);