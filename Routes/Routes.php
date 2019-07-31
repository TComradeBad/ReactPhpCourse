<?php


use tcb\Classes\HandlerFactory;
require __DIR__ . "/../Handlers/AllHandlersList.php";


$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $routes)
{
    $routes->get("/",HandlerFactory::get()["mainpage"]);

    $routes->get('/css/{cssname}',HandlerFactory::get()["css"]);

    $routes->get('/image/{imagename}',HandlerFactory::get()["image"]);

    $routes->get('/register',HandlerFactory::get()["register-get"]);

    $routes->post("/register",HandlerFactory::get()["register-post"]);

    $routes->get("/auth",HandlerFactory::get()["auth-get"]);

    $routes->post("/auth",HandlerFactory::get()["auth-post"]);

    $routes->get("/register_email_error",HandlerFactory::get()["register-email-error"]);

    $routes->get("/register_name_error",HandlerFactory::get()["register-name-error"]);

    $routes->get("/auth_error",HandlerFactory::get()["auth-error"]);

    $routes->get("/logout",HandlerFactory::get()["logout"]);

    $routes->get("/{user}/user_profile",HandlerFactory::get()["user-page"]);

    $routes->get("/{user}/image_upload",HandlerFactory::get()["image-upload-get"]);

    $routes->post("/{user}/image_upload",HandlerFactory::get()["image-upload-post"]);
});