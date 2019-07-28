<?php

use tcb\Classes\Handlers;
 use tcb\Classes\Middleware;


Handlers::addHandler("register-post",function (\Psr\Http\Message\ServerRequestInterface $request, $next){

    $dir = new \tcb\Classes\FileSystem();
    $result = $request->getParsedBody();
    $user = new \tcb\Classes\User($result['username'],$result["email"],$result["password"]);
    $user->pushToDB();

    return new \React\Http\Response(200,["Content-Type" => "text/html"],
        $dir->page('redirect.html',
            ["destination" => "http://192.168.33.10:8080/"]));

});

Handlers::addMiddlewareChain("register-post",Middleware::getChain("register-post"));

/**
 * Обработка post запроса аутенфикации пользователя
 */
Handlers::addHandler("auth-post",
    function (\Psr\Http\Message\ServerRequestInterface $request)
    {
        $dir = new \tcb\Classes\FileSystem();
        $result = $request->getParsedBody();
        $user = new \tcb\Classes\User($result['username'],null,$result["password"]);
        if(!($user->nameNotExistInDB()) & ($user->vertifyPassword()))
        {
            return new \React\Http\Response(200,
                [
                    "Content-Type" => "text/html",
                    "Set-Cookie" => "username=".$user->getUsername()
                ],
                $dir->page('redirect.html',
                    ["destination" => "http://192.168.33.10:8080/"]));
        }else
        {
            return new \React\Http\Response(200,["Content-Type" => "text/html"],
                $dir->page('redirect.html',
                    ["destination" => "http://192.168.33.10:8080/auth_error"]));
        }


    });