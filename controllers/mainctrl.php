<?php

class mainctrl{
    private $nombre;
    private $data;
    private $mensaje;
    private $errores;
    
    public function __construct($name=null) {
        $this->data=false;
        $this->mensaje=false;
        $this->errores=false;
        $this->nombre=$name;
    }
    
    //getters
    public function getNombre(){
        return $this->nombre;
    }
    
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
    public function setNombre($nombre){
        $this->data=$nombre;
    }
    
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