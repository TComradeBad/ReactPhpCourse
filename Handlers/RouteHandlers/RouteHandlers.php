<?php
use tcb\Classes\Handlers;

Handlers::Init(directory.'/Resourches/Html',false);


Handlers::addHandler("tasks",
    function (\Psr\Http\Message\ServerRequestInterface $request)
    {
        return new \React\Http\Response(200,["Content-Type" => "text/richtext" ],
        "task page");
    });


Handlers::addHandler("mainpage",
    function (\Psr\Http\Message\ServerRequestInterface $request)
    {
        return new \React\Http\Response(200, ["Content-Type" => "text/html"],
        Handlers::page("mainpage.html"));
    });
