<?php

namespace src\Controller;

use src\Library\View\View;
use src\Library\View\ViewAjax;
use Slim\Slim;
use src\Library\Smarty\Template;

abstract class Controller {

    public $view;
    public $viewAjax;
    public $session;
    public $app;
    private $template;

    public function __construct(Slim $app) {
        $this->app = $app;
        $this->view = new View($app);
        $this->viewAjax = new ViewAjax($app);
        $this->template = new Template($app);
    }

    public function render($template, array $params = null) {
        if ($params) {
            foreach ($params as $key => $param) {
                $this->template->assign($key, $param);
            }
        }
        return $this->template->display($template);
    }

    public function preController() {
        
    }

    public function postController() {
        
    }

    public function __invoke() {
        ;
    }

}
