<?php

use tcb\Classes\MiddlewareFactory;

$middleware = new MiddlewareFactory();
$middleware->addFunction(
    function (\Psr\Http\Message\ServerRequestInterface $request, $next, $user, $id) {
        $image = \tcb\Classes\ImageService::getImageById($id);

        if (empty($image)) {
            return new \React\Http\Response(404);

        } else return $next($request);
    });
$middleware->defineFunctionChain("image-exist");

$middleware = new MiddlewareFactory();
$middleware->addFunction(
    function (\Psr\Http\Message\ServerRequestInterface $request, $next, $user, $id) {
        $image = \tcb\Classes\ImageService::getImageById($id);
        $auth_user = $request->getCookieParams()["username"];

        if ($auth_user != $image["user_name"]) {
            return new \React\Http\Response(404);

        } else return $next($request);
    });
$middleware->defineFunctionChain("delete-access");
