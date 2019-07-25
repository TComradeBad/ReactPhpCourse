<?php

use tcb\Classes\Handlers;
require __DIR__."/../Handlers/RouteHandlers/RouteHandlers.php";
require __DIR__."/../Handlers/MainHandlers/MainHandlers.php";

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $routes)
{
    $routes->get('/tasks',Handlers::get()["tasks"]);

    $routes->get("/",Handlers::get()["mainpage"]);

    $routes->get('/css/{cssname}',Handlers::get()["css"]);

    $routes->get('/image/{imagename}',Handlers::get()["image"]);

    $routes->get('/register',Handlers::get()["register-get"]);

    $routes->post("/register",Handlers::get()["register-post"]);
});