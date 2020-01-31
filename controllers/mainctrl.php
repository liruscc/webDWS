<?php

class mainctrl{
    private $data;
    private $mensaje;
    private $errores;
    
    public function __construct() {
        $this->data=false;
        $this->mensaje=false;
        $this->errores=false;
    }
    
    //getters
    public function getData(){
        return $this->data;
    }
    
    public function getMensaje(){
        return $this->mensaje;
    }
    
    public function getErrores(){
        return $this->errores;
    }
    //setters
    public function setData($data){
        $this->data=$data;
    }
    
    public function setMensaje($mensaje){
        $this->mensaje=$mensaje;
    }
    
    public function setErrores($errores){
        $this->errores=$errores;
    }
}

?>