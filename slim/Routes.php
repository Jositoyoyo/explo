<?php

$app->get('/', function () {
    $response = new \src\Controller\Home\IndexController();
    $response->indexAction();
});

$app->get('/alertas', function () {
    $response = new \src\Controller\Alertas\AlertasController();
    $response->indexAction();
});

$app->group('/documentos', function () use ($app) {

    $app->get('/', function () use ($app) {
        $response = new src\Controller\Documentos\DocumentosController($app);
        $response->indexAction();
    })->name('documentos');

    $app->get('/explotacion/detalles/:id', function ($id) use ($app) {
        $response = new src\Controller\Documentos\DocumentosController($app);
        $response->detallesExplotacionAction($id);
    })->name('documetos-explotacion-detalles');

    $app->get('/plantillas', function () use ($app) {
        $response = new src\Controller\Documentos\DocumentosController($app);
        $response->plantillasAction();
    });

    $app->post('/plantillas/subir', function () use ($app) {
        $response = new src\Controller\Documentos\DocumentosController($app);
        $response->plantillaSubirAction();
    });

    $app->post('/buscar', function () use ($app) {
        $response = new \src\Controller\Explotaciones\AjaxController($app);
        $response->buscarExplotaciones();
    });

    $app->post('/generar', function () use ($app) {
        $response = new src\Controller\Documentos\GenerarDocumentoController($app);
        $response->generarDocumento();
    });
});

/** Artilleros * */
$app->group('/artilleros', function () use ($app) {
    $app->get('/', function () use ($app) {
        $response = new src\Controller\Artilleros\ArtillerosController($app);
        $response->indexAction();
    });
});

/** Empresas * */
$app->group('/empresas', function () use ($app) {
    $app->get('/', function () use ($app) {
        $response = new src\Controller\Empresas\EmpresasController($app);
        $response->indexAction();
    })->name('empresas-index');
});
