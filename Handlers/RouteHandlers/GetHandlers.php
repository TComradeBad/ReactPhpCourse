<?php
use tcb\Classes\Handlers;

/**
 * Главная страница
 */
Handlers::addHandler("mainpage",
    function (\Psr\Http\Message\ServerRequestInterface $request)
    {
        $dir = new \tcb\Classes\FileSystem();
        $cookie = $request->getCookieParams();
        if(isset($cookie["username"]))
        {
            $username = $cookie["username"];
        }

        return new \React\Http\Response(200, ["Content-Type" => "text/html"],
            $dir->page("mainpage.html",
            [
                "username" => $username,
                'image_array'=> array(
                "https://cdn52.zvooq.com/pic?type=release&id=6352180&size=200x200&ext=jpg",
                "https://im0-tub-ru.yandex.net/i?id=44d7bb844c3a61de224c3590a6c279c0&n=13&exp=1",
                "image/Heart.jpg",
                "image/disk.jpg",
                "image/blacksabbath.jpg"
                )]));
    });

/**
 * Страница регистрации
 */
Handlers::addHandler("register-get",
    function (\Psr\Http\Message\ServerRequestInterface $request)
    {
        $dir = new \tcb\Classes\FileSystem();
        return new \React\Http\Response(200, ["Content-Type" => "text/html"],
            $dir->page("register.html"));
    });

/**
 * Страница авторизации
 */
Handlers::addHandler("auth-get",
    function (\Psr\Http\Message\ServerRequestInterface $request)
    {
        $dir = new \tcb\Classes\FileSystem();
        return new \React\Http\Response(200, ["Content-Type" => "text/html"],
            $dir->page("auth.html"));
    });

/**
 * Регистрация с выводом ошибки почты
 */
Handlers::addHandler("register-email-error",
    function (\Psr\Http\Message\ServerRequestInterface $request)
    {
        $dir = new \tcb\Classes\FileSystem();
        return new \React\Http\Response(200, ["Content-Type" => "text/html"],
            $dir->page("register.html",
            [
                "errormessage" => "Данная электронная почта уже зарегестрирована"
            ]));
    });

/**
 * Регистрация с выводом ошибки имени пользователя
 */
Handlers::addHandler("register-name-error",
    function (\Psr\Http\Message\ServerRequestInterface $request)
    {
        $dir = new \tcb\Classes\FileSystem();
        return new \React\Http\Response(200, ["Content-Type" => "text/html"],
            $dir->page("register.html",
            [
                "errormessage" => "Имя уже занято"
            ]));
    });

/**
 * Авторизация с выводом ошибки
 */
Handlers::addHandler("auth-error",
    function (\Psr\Http\Message\ServerRequestInterface $request)
    {
        $dir = new \tcb\Classes\FileSystem();
        return new \React\Http\Response(200, ["Content-Type" => "text/html"],
            $dir->page("auth.html",
                [
                    "errormessage" => "Неправильное имя пользователя или пароль"
                ]));
    });

Handlers::addHandler("logout",
     function (\Psr\Http\Message\ServerRequestInterface $request)
     {
         $dir = new \tcb\Classes\FileSystem();
         return new \React\Http\Response(200,
             [
                 "Content-Type" => "text/html",
                 "Set-Cookie" => "username=".null
             ],
             $dir->page('redirect.html',
                 ["destination" => "http://192.168.33.10:8080/"]));
     });