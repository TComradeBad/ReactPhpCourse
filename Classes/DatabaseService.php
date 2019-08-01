<?php

namespace tcb\Classes;

class DatabaseService
{
    protected $dbOptions = [];

    public function __construct()
    {
        $this->dbOptions = include __DIR__."/../configs/databaseConfig.php";
    }

    public function connect()
    {
        $dsn = $this->dbOptions['db_type'].":host=".$this->dbOptions['host'].";dbname=".$this->dbOptions['db_name'].";charset=".$this->dbOptions['charset'].";";
        $connection = new \PDO($dsn,$this->dbOptions['user'],$this->dbOptions['password']);
        return $connection;
    }




}