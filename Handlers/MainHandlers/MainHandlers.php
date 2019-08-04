<?php

use tcb\Classes\HandlerFactory;


/**
 * Отправка браузеру файлов css
 */

HandlerFactory::addHandler("css",
    function (\Psr\Http\Message\ServerRequestInterface $request, $cssfilename) {
        $dir = new \tcb\Classes\FileSystem();
        return new \React\Http\Response(200, ["Content-Type" => "text/css"],
            $dir->css($cssfilename));
    });

/**
 * Отправка браузеру image файлов
 */
HandlerFactory::addHandler('image',
    function (\Psr\Http\Message\ServerRequestInterface $request, $imagefilename) {
        $dir = new \tcb\Classes\FileSystem();
        return new \React\Http\Response(200, ["Content-Type" => "image"],
            $dir->image($imagefilename));
    });
