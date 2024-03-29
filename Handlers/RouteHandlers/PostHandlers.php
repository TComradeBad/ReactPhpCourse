<?php

use tcb\Classes\HandlerFactory;
use tcb\Classes\MiddlewareFactory;

/**
 * Обработка post запроса с регистрации
 */
HandlerFactory::addHandler("register-post", function (\Psr\Http\Message\ServerRequestInterface $request) {

    $dir = new \tcb\Classes\FileSystem();
    $result = $request->getParsedBody();
    $user = new \tcb\Classes\User($result['username'], $result["email"], $result["password"]);
    $user->pushToDB();

    return new \React\Http\Response(200, ["Content-Type" => "text/html"],
        $dir->page('redirect.html',
            ["destination" => "http://192.168.33.10:8080/"]));

});

HandlerFactory::addMiddlewareChain("register-post", MiddlewareFactory::getFunctionChain("register-post"));

/**
 * Обработка post запроса аутенфикации пользователя
 */
HandlerFactory::addHandler("auth-post",
    function (\Psr\Http\Message\ServerRequestInterface $request) {
        $dir = new \tcb\Classes\FileSystem();
        $result = $request->getParsedBody();
        $user = new \tcb\Classes\User($result['username'], null, $result["password"]);
        return new \React\Http\Response(200,
            [
                "Content-Type" => "text/html",
                "Set-Cookie" => "username=" . $user->getUsername()
            ],
            $dir->page('redirect.html',
                ["destination" => "http://192.168.33.10:8080/"]));
    });

HandlerFactory::addMiddlewareChain("auth-post", MiddlewareFactory::getFunctionChain("auth-post"));

/**
 * Отправка картинок в базу данных
 */
HandlerFactory::addHandler("image-upload-post",
    function (\Psr\Http\Message\ServerRequestInterface $request, $user) {
        $dir = new \tcb\Classes\FileSystem();
        $user = str_replace("_", " ", $user);
        $result = $request->getParsedBody();
        $uploaded_image = $request->getUploadedFiles()["file"];
        $image = new \tcb\Classes\Image($uploaded_image, $result["name"], $user);
        $image->saveImagePushToDb();
        $user = str_replace(" ", "_", $user);
        return new \React\Http\Response(200, ["Content-Type" => "text/html"],
            $dir->page('redirect.html',
                ["destination" => "http://192.168.33.10:8080/$user/user_profile"]));

    });
HandlerFactory::addMiddlewareChain("image-upload-post", MiddlewareFactory::getFunctionChain("user-exist"));

/**
 * Обработка запроса на удаление картинки
 */
HandlerFactory::addHandler("image-delete",
    function (\Psr\Http\Message\ServerRequestInterface $request, $user, $id) {
        $dir = new \tcb\Classes\FileSystem();

        \tcb\Classes\ImageService::deleteImageById($id);
        return new \React\Http\Response(200, ["Content-Type" => "text/html"],
            $dir->page('redirect.html',
                ["destination" => "http://192.168.33.10:8080/$user/user_profile"]));

    });
HandlerFactory::addMiddlewareChain("image-delete", MiddlewareFactory::getFunctionChain("delete-access"));