<?php

namespace tcb\Classes;

class DatabaseService
{
    protected static $dbOptions = [];

    public function __construct()
    {

    }

    public static function initOptions($config)
    {
        self::$dbOptions = $config;
    }

    public function connect()
    {
        $dsn = self::$dbOptions['db_type'] . ":host=" . self::$dbOptions['host'] . ";dbname=" . self::$dbOptions['db_name'] . ";charset=" . self::$dbOptions['charset'] . ";";
        $connection = new \PDO($dsn, self::$dbOptions['user'], self::$dbOptions['password']);
        return $connection;
    }


}