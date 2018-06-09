<?php

namespace src\Controller\Alertas;

use src\Repository\Alertas\AlertasRepository;
use src\Controller\Controller;

class AlertasController extends Controller {
    
    public function index() {
        $this->view->display('/alertas/template.php', array('alertas' => null));
    }

    public function getAlertas() {
        $repository = new AlertasRepository();
        $render = new View();
        $alertas = $repository->findAll();
        $render->display('/var/www/html/trabajo/explosivos/branches/version2.4/slim/src/templates/alertas/template.php', array('alertas' => $alertas));
    }
    
    public function borrar() {
        
    }

    public function pager($page) {
        $repository = new AlertasRepository();
        $render = new View();
        $alertas = $repository->findAll($limit = 5,$page);
        $pager = \src\Library\Pager\Pager::PargeData($total = 100, $limit = 10, $page);
        $render->display('/var/www/html/trabajo/explosivos/branches/version2.4/slim/src/templates/alertas/template.php', array('alertas' => $alertas));
    }

}
