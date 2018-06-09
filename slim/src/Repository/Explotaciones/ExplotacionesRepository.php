<?php

namespace src\Repository\Explotaciones;

use src\Repository\Repository;
use PDO;

class ExplotacionesRepository extends Repository {

    public function __construct($app) {
        parent::__construct($app);
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

    public function findByAmbito($id) {
        $stmt = $this->connection->prepare('
            SELECT * 
            FROM explotaciones AS so
            INNER JOIN directores_facultativos AS s ON so.director = s.id
            INNER JOIN emp AS ex ON so.emp_exp = ex.id
            WHERE so.id = :id
        ');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        return $stmt->fetch();
    }

}
