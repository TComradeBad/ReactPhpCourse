<?php
use tcb\Classes\Handlers;

Handlers::Init(directory.'/Resourches/Html',directory.'/TwigCache');


Handlers::addHandler("tasks",
    function (\Psr\Http\Message\ServerRequestInterface $request)
    {
        return new \React\Http\Response(200,["Content-Type" => "text/html" ],
        "task page");
    });


Handlers::addHandler("mainpage",
    function (\Psr\Http\Message\ServerRequestInterface $request)
    {
        return new \React\Http\Response(200, ["Content-Type" => "text/html"],
        Handlers::$twig->render('mainpage.html'));
    });
