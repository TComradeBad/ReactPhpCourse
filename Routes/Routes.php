<?php

use tcb\Classes\Handlers;
require __DIR__."/../Handlers/RouteHandlers/RouteHandlers.php";


$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $routes)
{
    $routes->get('/tasks',Handlers::get()["tasks"]);

    $routes->get("/",Handlers::get()["mainpage"]);

    $routes->get('/css/{cssname}',Handlers::get()["css"]);


});