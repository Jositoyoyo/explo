<?php

namespace src\Controller\Explotaciones;

use src\Controller\Controller;
use src\Library\View\TemplateAjax;
use src\Repository\Explotaciones\ExplotacionesRepository;
use DirectoryIterator;

class AjaxController extends Controller {
    
    public function __construct($app) {
        parent::__construct($app);
    }
    
    public function buscarExplotaciones() {
        
        if ($this->app->request->isAjax()) {
            
            $explotaciones = new \src\Repository\Explotaciones\ExplotacionesRepository();
            $tipo = $this->app->request->post('tipo');
            $view = new TemplateAjax();
            $view->render('explotaciones/_explotaciones', array(
                'explotaciones' => $explotaciones->find($tipo),
                'dit' => new DirectoryIterator('/var/www/html/trabajo/explosivos/branches/version3.0/slim/public/uploads/plantillas')
            ));
            
        }
    }
}
