<?php

use tcb\Classes\Middleware;

$middleware = new \tcb\Classes\MiddlewareFactory();
$middleware->addFunction(
    function (\Psr\Http\Message\ServerRequestInterface $request, $next)
    {
        $dir = new \tcb\Classes\FileSystem();
        $result = $request->getParsedBody();
        $user = new \tcb\Classes\User($result['username'],$result["email"],$result["password"]);
        if(!$user->emailNotExistInDB())
        {
            return new \React\Http\Response(200,["Content-Type" => "text/html"],
                $dir->page('redirect.html',
                    ["destination" => "http://192.168.33.10:8080/register_email_error"]));
        }else return $next($request);
    });

$middleware->addFunction(function (\Psr\Http\Message\ServerRequestInterface $request, $next){

    $dir = new \tcb\Classes\FileSystem();
    $result = $request->getParsedBody();
    $user = new \tcb\Classes\User($result['username'],$result["email"],$result["password"]);
    if(!$user->nameNotExistInDB())
    {
        return new \React\Http\Response(200,["Content-Type" => "text/html"],
            $dir->page('redirect.html',
                ["destination" => "http://192.168.33.10:8080/register_name_error"]));

    }else return $next($request);
});
$middleware = $middleware->createMiddlewareChain();
Middleware::defineChain("register-post",$middleware);


