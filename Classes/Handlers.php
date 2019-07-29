<?php
/**
 * Created by PhpStorm.
 * User: Комрад
 * Date: 19.07.2019
 * Time: 16:03
 */

namespace tcb\Classes;

class Handlers
{
    /**
     * @var array
     */
    private static $handlers;



    public static function addHandler($handlerName,callable $handlerFunction)
    {
        self::$handlers[$handlerName] = $handlerFunction;

    }


    public static function get()
    {
        return self::$handlers;
    }

    public static function addMiddlewareChain($name,Middleware $middleware)
    {
        $mid = $middleware;
        $mid -> getLastMiddleware()->addNext(Handlers::get()[$name]);
        Handlers::addHandler($name,$mid);

    }
}