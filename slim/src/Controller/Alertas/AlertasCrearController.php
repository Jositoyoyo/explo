<?php

namespace src\Controller\Alertas;

use Slim\Slim;
use Slim\View;
use src\Services\CrearAlertasService;

class AlertasCrearController {
  
    public function crear() {
        $servicio = new CrearAlertasService();
        $servicio->crear();
    }

}
