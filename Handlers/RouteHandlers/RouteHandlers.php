<?php
use tcb\Classes\Handlers;
$dir = include __DIR__."/../../configs/directoriyConfig.php";

Handlers::Init($dir["html_dir"],false);


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

Handlers::addHandler("css",
    function (\Psr\Http\Message\ServerRequestInterface $request,$cssfilename) use ($dir)
    {
        return new \React\Http\Response(200, ["Content-Type" => "text/css"],
            file_get_contents($dir["root_dir"]."/css/".$cssfilename));

    });