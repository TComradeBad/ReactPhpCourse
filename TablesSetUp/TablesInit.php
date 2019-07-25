<?php

require __DIR__."/../vendor/autoload.php";

$connection =(new \tcb\Classes\DatabaseService())->connect();
if($connection)
{
    $qbuilder = new \tcbQB\QueryBuilder\QueryBuilder();


    $query = $qbuilder->create('react_users')->integer('id',"NOT NULL AUTO_INCREMENT PRIMARY KEY")
        ->varchar("user_name",255,"UNIQUE")
        ->varchar("email",255,"UNIQUE")
        ->varchar("password",255)
        ->get();

    $connection->query($query);


}