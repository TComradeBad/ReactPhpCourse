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
    public function __construct($username, $email, $password)
    {
        $this->username = htmlspecialchars(stripslashes($username));
        $this->email = htmlspecialchars(stripslashes($email));
        $this->password = htmlspecialchars(stripslashes($password));


    }

    public function pushToDB()
    {
        $builder = new QueryBuilder();
        $db = new DatabaseService();
        $connection = $db->connect();
        if ($connection) {
            $query = $builder->insert($this->table, ["user_name", "email", "password"])
                ->values([
                    AbstractQuery::sqlString($this->username),
                    AbstractQuery::sqlString($this->email),
                    AbstractQuery::sqlString(password_hash($this->password, PASSWORD_DEFAULT))
                ])->get();
            $connection->query($query);

        }
    }

    public function nameNotExistInDB()
    {
        $builder = new QueryBuilder();
        $db = new DatabaseService();
        $connection = $db->connect();
        if ($connection) {
            $query = $builder->select("user_name")->from(['react_users'])->where()
                ->equals("user_name", AbstractQuery::sqlString($this->username))->get();
            $row = $connection->query($query);
            $row = $row->fetch();
            if (empty($row['user_name'])) {
                return true;
            } else {
                return false;
            }
        }

    }

    public function emailNotExistInDB()
    {
        $builder = new QueryBuilder();
        $db = new DatabaseService();
        $connection = $db->connect();
        if ($connection) {
            $query = $builder->select("email")->from(['react_users'])->where()
                ->equals("email", AbstractQuery::sqlString($this->email))->get();
            $row = $connection->query($query);
            $row = $row->fetch();
            if (empty($row['email'])) {
                return true;
            } else {
                return false;
            }
        }

    }

    public function vertifyPassword()
    {
        $builder = new QueryBuilder();
        $db = new DatabaseService();
        $connection = $db->connect();
        if ($connection) {
            $query = $builder->select("password")->from(['react_users'])->where()
                ->equals("user_name", AbstractQuery::sqlString($this->username))->get();
            $row = $connection->query($query);
            $row = $row->fetch();
            return password_verify($this->password, $row["password"]);
        } else {
            return false;
        }

    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}