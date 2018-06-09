<?php

namespace src\Services;

use src\Library\Fechas\CalcularFechas;
use src\Repository\Artilleros\Artilleros;
use src\Repository\Alertas\AlertasCrear;
use src\Services\CrearAlertasService;
use src\Entity\ArtilleroEntity;

class CrearAlertasService {

    public function crear() {

        $hoy = date('Y-m-d');
        $proximo_mes = CalcularFechas::calcularProximoMes();
        $ambito = $_SESSION['ambito'];

        $artilleros = new Artilleros();
        if ($artilleros = $artilleros->findByFechaFin($ambito, $hoy, $proximo_mes)) {
            foreach ($artilleros as $artillero) {
                $this->crearAlertaCarnetArtillero(new ArtilleroEntity($artillero));
            }
        }
    }

    public function crearAlertaCarnetArtillero(ArtilleroEntity $artillero) {
        
        $connection = new \src\Library\PDOConnection();
        $stmt = $connection->prepare('
            INSERT INTO alertas (id, alerta, ambito) 
            VALUES (:id, :alerta, :ambito)
        ');

        $id = $artillero->custom();
        $link = $artillero->link();
        $ambito = $artillero->getAmbito();

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':alerta', $link);
        $stmt->bindParam(':ambito', $ambito);
        return $stmt->execute();
    }

}
