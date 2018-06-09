<?php

$_appstage_development = 'development';
$_appstage_testing = 'testing';
$_appstage_production = 'production';

$servers = array(
    'app-php.dev' => $_appstage_development,
    'localhost' => $_appstage_development,
);

/*
 * ?? revisar
 */
if (!function_exists('mime_content_type')) {

    function mime_content_type($filename) {
        if (file_exists($filename)) {
            $res = exec('file -i ' . escapeshellarg($filename));
            $res = explode(' ', $res);
            return trim(str_replace(';', '', $res[1]));
        }

        return NULL;
    }

}

if (isset($servers[$_SERVER['HTTP_HOST']])) { 
    define('APPSTAGE', $servers[$_SERVER['HTTP_HOST']]);
    define('BASE_APPLICATION_PATH', __DIR__ );
    define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/src/'));
    define('BASE_PUBLIC', realpath(dirname(__FILE__)) . '/public/');
    define('TEMPLATES_PATH', realpath(dirname(__FILE__) . '/src/templates/'));
} else {
    die('La aplicacion no esta instalada correctamente. El servidor no es valido ' . $_SERVER['HTTP_HOST']);
}

unset($servers);

try {
    
    $loader = require_once 'vendor/autoload.php';
    $loader->add('src\\', BASE_APPLICATION_PATH);
    require_once 'src/Bootstrap.php';
    $slim = new \Slim\Slim();
    
    $bootstrap = new Bootstrap($slim);
    $app = $bootstrap->exec();    
    //iniciamos las session
    
} catch (Exception $ex) {

    $html = '<html><body>' .
            '<h1>An exception occured while bootstrapping the application</h1>';
//cambiar TODO
    if (defined('APPSTAGE')) { // && APPSTAGE != 'production' ) {
        $html .= '<p><b>Error: </b>' . $exception->getMessage() . '</p>' .
                '<div align="left">Stack Trace:<pre>' .
                $exception->getTraceAsString() .
                '</pre></div>';
    }

    $html .= '</body></html>';
    echo $html;
    exit();
}
$app->run();
