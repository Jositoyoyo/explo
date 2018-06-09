<?php

namespace src\Repository;

use src\Library\PDOConnection;
use PDO;
use Slim\Slim;

abstract class Repository {

    protected $connection;
    protected $limit;
    protected $page;

    public function __construct(Slim $app) {
        if ($app->config('database')) {
            $connection = new PDOConnection($app->config('database'));
            $this->connection = $connection->getConnection();
        } else {
            throw new Exception('Ha ocurrido un error');
        }
    }

}
