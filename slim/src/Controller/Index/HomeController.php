<?php

namespace src\Controller\Home;

use src\Controller\Controller;

class HomeController extends Controller {

    public function index() {
       $this->view->display('index.php', array());
    }
    
}
