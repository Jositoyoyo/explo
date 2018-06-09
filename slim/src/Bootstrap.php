<?php

use Slim\Slim;
use src\Library\Session\AppSession;
use src\Library\Session\SessionManager;

final class Bootstrap {

    private $container;
    private $config;
    private $app;

    public function __construct(Slim $app) {

        switch (APPSTAGE) {
            case 'development':
                error_reporting(-1);
                ini_set('display_errors', 1);
                break;

            case 'testing':
            case 'production':
                ini_set('display_errors', 0);
                error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
                break;

            default:
                header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
                echo 'The application environment is not set correctly.';
                exit(1); // EXIT_ERROR
        }

        
        
        $config = require APPLICATION_PATH . '/Config/Config.php';
        $routes = require BASE_APPLICATION_PATH . '/Routes.php';
        $contents = require APPLICATION_PATH . '/Config/Container.php';
        $Hooks = require APPLICATION_PATH . '/Config/Hooks.php';
        $middleware = require APPLICATION_PATH . '/Config/Middleware.php';
        $this->app = $app;
    }

    public function exec() {
        return $this->app;
    }

}
