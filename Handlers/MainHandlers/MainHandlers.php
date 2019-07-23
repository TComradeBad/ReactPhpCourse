<?php

use tcb\Classes\Handlers;



/**
 * Отправка браузеру файлов css
 */

Handlers::addHandler("css",
    function (\Psr\Http\Message\ServerRequestInterface $request,$cssfilename)
    {
        $dir = new \tcb\Classes\FileSystem();
        return new \React\Http\Response(200, ["Content-Type" => "text/css"],
           $dir->css($cssfilename));
    });

/**
 * Отправка браузеру image файлов
 */
Handlers::addHandler('image',
    function (\Psr\Http\Message\ServerRequestInterface $request,$imagefilename)
    {
        $dir = new \tcb\Classes\FileSystem();
        return new \React\Http\Response(200, ["Content-Type" => "image"],
            $dir->image($imagefilename));
    });
