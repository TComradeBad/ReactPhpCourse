<?php

namespace tcb\Classes;
use tcb\Classes\DatabaseService;
use tcbQB\QueryBuilder\AbstractQuery;
use tcbQB\QueryBuilder\QueryBuilder;

class User
{
    protected $table = "react_users";

    protected $username;

    protected $email;

    protected $password;

    /**
     * User constructor.
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct($username,$email,$password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;

    }

    public function pushToDB()
    {
        $builder = new QueryBuilder();
        $db = new DatabaseService();
        $connection = $db->connect();
        if($connection)
        {
            $query = $builder ->insert($this->table,["user_name","email","password"])
                ->values([
                    AbstractQuery::sqlString($this->username),
                    AbstractQuery::sqlString($this->email),
                    AbstractQuery::sqlString($this->password)
                ])->get();
            $connection->query($query);

        }
    }

}