<?php

namespace src\Repository\Consumo;

use src\Library\PDOConnection;
use src\Repository\Repository;
use PDO;

class ConsumoRepository extends Repository {

    public function findByExplotacion($explotacion) {

        $stmt = $this->connection->prepare('
        SELECT * FROM consumo AS so
            LEFT JOIN gc AS s ON so.gc = s.id
            INNER JOIN proveedores AS ex ON so.proveedor = ex.id
            WHERE so.explotacionesid = :explotacion 
            AND so.vencido = 0 
            ORDER BY so.fecha ASC
        ');
        $stmt->bindParam(':explotacion', $explotacion);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        return $stmt->fetchAll();
    }

}
