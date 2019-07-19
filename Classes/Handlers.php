<?php
/**
 * Created by PhpStorm.
 * User: Комрад
 * Date: 19.07.2019
 * Time: 16:03
 */

namespace tcb\Classes;
use Twig_Loader_Filesystem;
use Twig_Environment;

class Handlers
{

    private static $handlers;
    private static $loader;
    public static $twig;

    public static function Init($twigLoader, $cacheDirectory)
    {
        self::$handlers = array();
        self::$loader = new Twig_Loader_Filesystem( $twigLoader);
        self::$twig = new Twig_Environment(self::$loader, array(
            'cache' => $cacheDirectory,
        ));
    }

    public static function addHandler($handlerName,callable $handlerFunction)
    {
        self::$handlers[$handlerName] = $handlerFunction;

    }

    public static function get()
    {
        return self::$handlers;
    }
}