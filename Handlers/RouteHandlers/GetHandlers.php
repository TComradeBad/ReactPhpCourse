<?php

use tcb\Classes\HandlerFactory;
use tcb\Classes\MiddlewareFactory;

/**
 * Главная страница
 */
HandlerFactory::addHandler("mainpage",
    function (\Psr\Http\Message\ServerRequestInterface $request) {
        $dir = new \tcb\Classes\FileSystem();
        $cookie = $request->getCookieParams();
        if (isset($cookie["username"])) {
            $username = $cookie["username"];
        }

        $image_array = \tcb\Classes\ImageService::getImageRefArray();
        return new \React\Http\Response(200, ["Content-Type" => "text/html"],
            $dir->page("mainpage.html",
                [
                    "username_ref" => str_replace(" ", "_", $username),
                    "username" => $username,
                    'image_array' => $image_array
                ]));
    });

/**
 * Страница регистрации
 */
HandlerFactory::addHandler("register-get",
    function (\Psr\Http\Message\ServerRequestInterface $request) {
        $dir = new \tcb\Classes\FileSystem();
        return new \React\Http\Response(200, ["Content-Type" => "text/html"],
            $dir->page("register.html"));
    });

/**
 * Страница авторизации
 */
HandlerFactory::addHandler("auth-get",
    function (\Psr\Http\Message\ServerRequestInterface $request) {
        $dir = new \tcb\Classes\FileSystem();
        return new \React\Http\Response(200, ["Content-Type" => "text/html"],
            $dir->page("auth.html"));
    });

/**
 * Регистрация с выводом ошибки почты
 */
HandlerFactory::addHandler("register-email-error",
    function (\Psr\Http\Message\ServerRequestInterface $request) {
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
HandlerFactory::addHandler("register-name-error",
    function (\Psr\Http\Message\ServerRequestInterface $request) {
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
HandlerFactory::addHandler("auth-error",
    function (\Psr\Http\Message\ServerRequestInterface $request) {
        $dir = new \tcb\Classes\FileSystem();
        return new \React\Http\Response(200, ["Content-Type" => "text/html"],
            $dir->page("auth.html",
                [
                    "errormessage" => "Неправильное имя пользователя или пароль"
                ]));
    });

/**
 * Выход из аккаунта
 */
HandlerFactory::addHandler("logout",
    function (\Psr\Http\Message\ServerRequestInterface $request) {
        $dir = new \tcb\Classes\FileSystem();
        return new \React\Http\Response(200,
            [
                "Content-Type" => "text/html",
                "Set-Cookie" => "username=" . null
            ],
            $dir->page('redirect.html',
                ["destination" => "http://192.168.33.10:8080/"]));
    });

/**
 * Страница пользователя вместе с его картинками
 */
HandlerFactory::addHandler("user-page",
    function (\Psr\Http\Message\ServerRequestInterface $request, $user) {
        $user = str_replace("_", " ", $user);
        $auth_user = $request->getCookieParams()["username"];
        $dir = new \tcb\Classes\FileSystem();
        $image_array = \tcb\Classes\ImageService::getImageRefArray($user);
        return new \React\Http\Response(200, ["Content-Type" => "text/html"],
            $dir->page("userpage.html",
                [
                    "user_ref" => str_replace(" ", "_", $user),
                    "username" => $auth_user,
                    'image_array' => $image_array
                ]));
    });
HandlerFactory::addMiddlewareChain("user-page", MiddlewareFactory::getFunctionChain("user-exist"));

/**
 * Страница загрузки изображений
 */
HandlerFactory::addHandler("image-upload-get",
    function (\Psr\Http\Message\ServerRequestInterface $request, $user) {
        $auth_user = $request->getCookieParams()["username"];
        $dir = new \tcb\Classes\FileSystem();
        return new \React\Http\Response(200, ["Content-Type" => "text/html"],
            $dir->page("image_upload.html",
                [
                    "userref" => $user,
                    "username" => $auth_user
                ]));

    });
HandlerFactory::addMiddlewareChain("image-upload-get", MiddlewareFactory::getFunctionChain("user-exist"));

/**
 * Страница с определенной картинкой
 */
HandlerFactory::addHandler("image-view",
    function (\Psr\Http\Message\ServerRequestInterface $request, $user, $id) {
        $auth_user = $request->getCookieParams()["username"];
        $dir = new \tcb\Classes\FileSystem();
        \tcb\Classes\ImageService::increaseViewsCountById($id);

        $image = \tcb\Classes\ImageService::getImageById($id);

        return new \React\Http\Response(200, ["Content-Type" => "text/html"],
            $dir->page("image_view.html",
                [
                    "username" => $auth_user,
                    "image_source" => "/image/" .
                        str_replace(" ", "_", $image["user_name"]) . "/" .
                        str_replace(" ", "_", $image["file_name"]),
                    "image_name" => $image["image_name"],
                    "delete_button" => ($image["user_name"] == $auth_user),
                    "image_authorref" => $user,
                    "image_id" => $id
                ]));

    });
HandlerFactory::addMiddlewareChain("image-view", MiddlewareFactory::getFunctionChain("image-exist"));
