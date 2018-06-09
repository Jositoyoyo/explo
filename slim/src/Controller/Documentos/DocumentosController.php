<?php

namespace src\Controller\Documentos;

use src\Controller\Controller;
use src\Repository\Explotaciones\ExplotacionesRepository;
use src\Repository\Plantillas\PlantillasRepository;
use src\Repository\Consumo\ConsumoRepository;

class DocumentosController extends Controller {

    public function __construct($app) {
        parent::__construct($app);
    }

    public function indexAction() {
        $explotaciones = new ExplotacionesRepository($this->app);
        $this->view->display('documentos/index', array(
            'explotaciones' => $explotaciones->findByAmbito($ambito=1),
        ));
        
    }

    public function detallesExplotacionAction($id) {
        
        $app = $this->app;
        $explotacion = new ExplotacionesRepository($app);
        $consumo = new ConsumoRepository($app);
        $plantillas = new PlantillasRepository($app);

        $this->view->display('documentos/detalles', array(
            'explotacion' => $explotacion->findByAmbito($id),
            'consumo' => $consumo->findByExplotacion($id)
        ));
    }

    public function plantillasAction() {
        $this->view->display('documentos/plantillas', array(
        ));
    }

    public function plantillaSubirAction() {
        $fileManager = new \src\Services\UploadFileService($this->app);
        if ($fileManager->guardar()) {
            $this->app->redirect('documentos/plantillas');
            // $this->app->flash('error', $e->getMessage());
        } else {
            $app->redirect('/error');
        }
    }

}
