<?php
/**
 * Created by PhpStorm.
 * User: Комрад
 * Date: 04.08.2019
 * Time: 18:51
 */

namespace tcb\Classes;
use Dotenv\Dotenv;

class Initializer
{

    public static function InitAll(&$url, $url_type)
    {
        $dotenv = Dotenv::create(__DIR__ . "/../configs/ENV/", "databaseConfig.env");
        $dotenv->overload();

        \tcb\Classes\DatabaseService::initOptions(include __DIR__ . "/../configs/databaseConfig.php");
        \tcb\Classes\FileSystem::initDirectories(include __DIR__ . "/../configs/directoryConfig.php");

        $url = include __DIR__."/../configs/urlConfig.php";
        $url = $url[$url_type];
    }
}