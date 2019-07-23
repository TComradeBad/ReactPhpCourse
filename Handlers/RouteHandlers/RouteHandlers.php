<?php
use tcb\Classes\Handlers;

Handlers::addHandler("tasks",
    function (\Psr\Http\Message\ServerRequestInterface $request)
    {
        return new \React\Http\Response(200,["Content-Type" => "text/richtext" ],
        "task page");
    });


Handlers::addHandler("mainpage",
    function (\Psr\Http\Message\ServerRequestInterface $request)
    {
        $dir = new \tcb\Classes\FileSystem();

        return new \React\Http\Response(200, ["Content-Type" => "text/html"],
        $dir->page("mainpage.html",
            ['image_array'=> array(
                "https://cdn52.zvooq.com/pic?type=release&id=6352180&size=200x200&ext=jpg",
                "https://im0-tub-ru.yandex.net/i?id=44d7bb844c3a61de224c3590a6c279c0&n=13&exp=1",
                "image/Heart.jpg",
                "image/disk.jpg",
                "image/blacksabbath.jpg"
                )]));
    });

