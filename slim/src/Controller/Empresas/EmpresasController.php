<?php

namespace src\Controller\Empresas;

use src\Controller\Controller;

use src\Library\Smarty\Template;

class EmpresasController extends Controller {

    public function __construct($app) {
        parent::__construct($app);
    }

    public function indexAction() {
        $this->render('empresas/index.tpl');
    }

}
