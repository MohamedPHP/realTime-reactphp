<?php

use React\Socket\ConnectionInterface;

class ConnectionsPool
{
    private $connections;

    public function __construct()
    {
        $this->connections = new SplObjectStorage();
    }

    /**
     * @param ConnectionInterface $connection
     * @return void
     */
    public function add(ConnectionInterface $connection) : void
    {
        $connection->write("Hi There \n");

        $connection->write("Enter You Name: \n");

        $this->setConnectionName($connection, '');

        $this->initEvents($connection);
    }

    /**
     * @param ConnectionInterface $connection
     * @return void
     */
    private function initEvents(ConnectionInterface $connection) : void
    {
        $connection->on('data', function ($data) use ($connection) {
            $name = $this->getConnectionName($connection);
            if (empty($name)) {
                $this->addNewMember($connection, $data);
            } else {
                $this->sendAll("$name: $data", $connection);
            }
        });

        $connection->on('close', function () use ($connection) {
            $name = $this->getConnectionName($connection);
            $this->connections->offsetUnset($connection);
            $this->sendAll("$name: Left The Chat \n", $connection);
        });
    }

    /**
     * @param ConnectionInterface $connection
     * @param string $name
     * @return void
     */
    public function addNewMember($connection, $name) : void
    {
        $name = str_replace(["\n", "\r"], '', $name);
        $this->setConnectionName($connection, $name);
        $this->sendAll("$name Just Joined The Chat \n", $connection);
    }

    /**
     * @param ConnectionInterface $connection
     * @return SplObjectStorage
     */
    public function getConnectionName(ConnectionInterface $connection) : string
    {
        return $this->connections->offsetGet($connection);
    }

    /**
     * @param ConnectionInterface $connection
     * @return void
     */
    public function setConnectionName(ConnectionInterface $connection, string $name) : void
    {
        $this->connections->offsetSet($connection, $name);
    }

    /**
     * string $message
     * ConnectionInterface $expect
     * @return void
     */
    public function sendAll(string $message, ConnectionInterface $expect) : void
    {
        foreach ($this->connections as $conn) {
            if ($conn != $expect) {
                $conn->write($message);
            }
        }
    }
}
