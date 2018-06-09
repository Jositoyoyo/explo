<?php

//temporarl cambiar por una configuracion con Json y añadir App_Config
$global = array(
    'enviroment' => APPSTAGE,
    'log.enabled' => true,
    'log.level' => \Slim\Log::DEBUG,
    'debug' => true,
    'routes' => '../templates',
    'configuration' => '',
    'templates' => APPLICATION_PATH . '/templates/',
    'uploaddir_templates' => '/var/www/html/trabajo/explosivos/branches/version3.0/slim/public/uploads/plantillas/'
);
switch (APPSTAGE) {
    case 'development':
        $config = array(
            'database' => array(
                'host' => 'localhost',
                'dbname' => 'explosivos_back_191217',
                'user' => 'root',
                'pass' => 'jositoyoyo'
            )
        );
        break;

    case 'testing':
        $config = array();
        break;

    case 'production':
        $config = array();
        break;
}

$app->config(array_merge($global, $config));
