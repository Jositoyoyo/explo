<?php

namespace src\Repository\Artilleros;

use src\Library\PDOConnection;
use src\Repository\Repository;
use PDO;

class ArtillerosRepository extends Repository {
    
    public function __construct(\Slim\Slim $app) {
        parent::__construct($app);
    }

    public function findById($ambito, $hoy, $proximo_mes) {

        $stmt = $this->connection->prepare('
            SELECT * 
            FROM artilleros 
            WHERE ambito= :ambito AND ffin between :hoy AND :proximo_mes'
        );
        $stmt->bindParam(':ambito', $ambito);
        $stmt->bindParam(':hoy', $hoy);
        $stmt->bindParam(':proximo_mes', $proximo_mes);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        return $stmt->fetchAll();
    }
    
    public function findAll($ambito=1) {
        $stmt = $this->connection->prepare('
            SELECT * 
            FROM artilleros 
            WHERE ambito= :ambito
            LIMIT 0, 300'
        );
        $stmt->bindParam(':ambito', $ambito);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        return $stmt->fetchAll();
    }

}
