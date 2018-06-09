<?php

namespace src\Library;

use PDO;

class PDOConnection {

    private $connection;

    public function __construct(array $config) {
        
        try {
            $this->connection = new PDO(
                    'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . ';charset=utf8', $config['user'], $config['pass']
            );
            $this->connection->setAttribute(
                    PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        
    }

    public function getConnection() {
        return $this->connection;
    }

}
