<?php

use tcb\Classes\Middleware;

$middleware = new Middleware(
    function (\Psr\Http\Message\ServerRequestInterface $request, $next){
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

$middleware->addNext(function (\Psr\Http\Message\ServerRequestInterface $request, $next){

    $dir = new \tcb\Classes\FileSystem();
    $result = $request->getParsedBody();
    $user = new \tcb\Classes\User($result['username'],$result["email"],$result["password"]);
    if(!$user->nameNotExistInDB())
    {
        return new \React\Http\Response(200,["Content-Type" => "text/html"],
            $dir->page('redirect.html',
                ["destination" => "http://192.168.33.10:8080/register_name_error"]));

    }else return $next($request);
})->addNext(function (\Psr\Http\Message\ServerRequestInterface $request, $next){

    $dir = new \tcb\Classes\FileSystem();
    $result = $request->getParsedBody();
    $user = new \tcb\Classes\User($result['username'],$result["email"],$result["password"]);
    $user->pushToDB();

    return new \React\Http\Response(200,["Content-Type" => "text/html"],
        $dir->page('redirect.html',
            ["destination" => "http://192.168.33.10:8080/"]));

});

Middleware::createChain("register-post",$middleware);


