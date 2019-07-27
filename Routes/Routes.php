<?php

use tcb\Classes\Handlers;
require __DIR__ . "/../Handlers/RouteHandlers/GetHandlers.php";
require __DIR__ . "/../Handlers/RouteHandlers/PostHandlers.php";
require __DIR__."/../Handlers/MainHandlers/MainHandlers.php";

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $routes)
{
    $routes->get("/",Handlers::get()["mainpage"]);

    $routes->get('/css/{cssname}',Handlers::get()["css"]);

    $routes->get('/image/{imagename}',Handlers::get()["image"]);

    $routes->get('/register',Handlers::get()["register-get"]);

    $routes->post("/register",Handlers::get()["register-post"]);

    $routes->get("/auth",Handlers::get()["auth-get"]);

    $routes->post("/auth",Handlers::get()["auth-post"]);

    $routes->get("/register_email_error",Handlers::get()["register-email-error"]);

    $routes->get("/register_name_error",Handlers::get()["register-name-error"]);

    $routes->get("/auth_error",Handlers::get()["auth-error"]);

    $routes->get("/logout",Handlers::get()["logout"]);
});