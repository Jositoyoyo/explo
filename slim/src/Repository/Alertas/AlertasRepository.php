<?php

namespace src\Repository\Alertas;

use src\Library\PDOConnection;
use src\Repository\Repository;
use PDO;

class AlertasRepository extends Repository {

    public function findByAmbito($ambito) {
        $stmt = $this->connection->prepare('
            SELECT * 
             FROM alertas 
             WHERE ambito = :ambito
             ORDER BY alerta_id DESC
             LIMIT 0,30
        ');
        $stmt->bindParam(':ambito', $ambito);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        return $stmt->fetchAll();
    }

    public function findAll($limit = 5, $page = 1) {

        $offset = ($page - 1) * $limit;
        $stmt = $this->connection->prepare('
            SELECT * 
             FROM alertas
             WHERE borrada != 1
             ORDER BY alerta_id DESC
             LIMIT :limit OFFSET :offset
        ');
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        return $stmt->fetchAll();
    }  

    public function borrar($id) {
        $stmt = $this->connection->prepare('
            DELETE FROM  alertas
            WHERE id = :id
        ');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

}
