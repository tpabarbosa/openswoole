<?php

namespace App;

use PDO;
use PDOException;

class DbConnection
{
    private $connection;
    public function __construct()
    {
        try {
            $pdo = sprintf('mysql:host=%s;port=%s;dbname=%s', DB_HOST, DB_PORT, DB_DATABASE);
            $this->connection = new PDO($pdo, DB_USER, DB_PASSWORD);

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            var_dump($this->connection);
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    public function connect()
    {

        return $this->connection;
    }
}
