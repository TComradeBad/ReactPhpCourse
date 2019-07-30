<?php

namespace tcb\Classes;



class HandlerFactory
{
    /**
     * @var array
     */
    protected static $handlers = array();


    protected static $function;


    public static function addHandler($handlerName,callable $handlerFunction)
    {
        self::$handlers[$handlerName] = $handlerFunction;

    }


    public static function get()
    {
        return self::$handlers;
    }

    public static function addMiddlewareChain($name, $middleware_array)
    {
        $middleware = MiddlewareFactory::createMiddlewareChain($middleware_array);
        $handler = new Handler(HandlerFactory::get()[$name],$middleware);
        HandlerFactory::addHandler($name,$handler);

    }
}