<?php

class controller {

    private $nombre;
    private $archivo;

    function __construct($nombre) {
        $this->nombre = $nombre;
        $this->archivo = 'controllers/' . $nombre . 'ctrl.php';
    }

    function getNombre() {
        return $this->nombre;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function getArchivo() {
        return $this->archivo;
    }

    function setArchivo($archivo) {
        $this->archivo = $archivo;
    }

}
?>