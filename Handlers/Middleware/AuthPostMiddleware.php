<?php

use tcb\Classes\Middleware;

$middleware = new Middleware(
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