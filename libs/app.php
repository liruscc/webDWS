<?php

require_once('libs/controller.php');
require_once('libs/view.php');

class app {

    private $controller;
    private $view;

    function __construct($nombre) {
        $this->controller = new controller($nombre);
        $this->view = new view($nombre);
    }
    
    public function render(){
       // print_r($this);
        require_once($this->controller->getArchivo());
        require_once($this->view->getArchivo());
    }
}
?>