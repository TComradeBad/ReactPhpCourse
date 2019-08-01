<?php

/** Middleware **/
require __DIR__ . "/Middleware/AuthPostMiddleware.php";
require __DIR__ . "/Middleware/RegisterPostMiddleware.php";
require __DIR__ . "/Middleware/UserExistMiddleware.php";

/** HandlerFactory**/
require __DIR__ . "/RouteHandlers/GetHandlers.php";
require __DIR__ . "/RouteHandlers/PostHandlers.php";
require __DIR__ . "/MainHandlers/MainHandlers.php";