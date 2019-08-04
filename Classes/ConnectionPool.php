<?php

namespace tcb\Classes;

use React\Socket\ConnectionInterface;

class ConnectionPool
{

    protected $connections = null;

    public function __construct()
    {
        $this->connections = new \SplObjectStorage();
    }

    public function addConnection(\React\Socket\ConnectionInterface $connection)
    {
        $connection->write("hello" . PHP_EOL);
        $connection->write("type your name:");
        $this->connections->attach($connection);

        $connection->on("data", function ($data) use ($connection) {
            if ($this->getConnectionName($connection) == null) {
                $this->setConnectionName($connection, $data);
            } else {
                foreach ($this->connections as $conn) {
                    if ($conn != $connection) {
                        $conn->write($this->getConnectionName($connection) . ": " . $data);

                    }
                }
            }

        });

        $connection->on("close", function () use ($connection) {
            $this->connections->detach($connection);
        });

    }

    public function getConnectionName(ConnectionInterface $connection)
    {
        return $this->connections->offsetGet($connection);
    }

    public function setConnectionName(ConnectionInterface $connection, $name)
    {
        $name = str_replace(["\n", "\r"], "", $name);
        $this->connections->offsetSet($connection, $name);
    }
}