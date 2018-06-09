<?php

namespace src\Controller\Artilleros;

use src\Controller\Controller;
use src\Repository\Artilleros\ArtillerosRepository;

class ArtillerosController extends Controller {

    public function __construct($app) {
        parent::__construct($app);
    }

    public function indexAction() {
        $app = $this->app;
        $artilleros = new ArtillerosRepository($app);

        $this->view->display('artilleros/detalles', array(
            'artilleros' => $artilleros->findAll(1)
        ));
    }

}
