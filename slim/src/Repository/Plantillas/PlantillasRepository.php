<?php

namespace src\Repository\Plantillas;

use src\Repository\Repository;
use PDO;

class PlantillasRepository extends Repository {

    public function findByAmbito($ambito = null) {

        $stmt = $this->connection->prepare('
            SELECT *
            FROM plantillas 
            LIMIT 0, 30'
        );
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        return $stmt->fetchAll();
    }

    public function findOneById($id) {
        $stmt = $this->connection->prepare('
            SELECT * 
            FROM explotaciones 
            WHERE id = :id'
        );
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        return $stmt->fetch();
    }

    public function save($nombre) {
        $stmt = $this->connection->prepare('
            INSERT INTO plantillas (nombre) 
            VALUES (:nombre)
        ');
        $stmt->bindParam(':nombre', $nombre);
        return $stmt->execute();
    }

}
