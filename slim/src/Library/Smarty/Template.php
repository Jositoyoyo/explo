<?php

namespace src\Library\Smarty;

require('Smarty.class.php');

class Template extends \Smarty {

    function __construct(\Slim\Slim $app) {
        parent::__construct();
        $this->setTemplateDir(TEMPLATES_PATH);
        $this->setCompileDir(TEMPLATES_PATH . 'templates_c/');
        $this->setConfigDir(TEMPLATES_PATH . 'Config/');
        $this->setCacheDir(BASE_APPLICATION_PATH . 'cache/');
        
        //$this->debugging = true;
    }

}
