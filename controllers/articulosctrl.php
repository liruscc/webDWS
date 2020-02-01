<?php
require_once('controllers/mainctrl.php');
require_once('classes/articulo.php');

class articulosctrl extends mainctrl {

    function __construct() {
        parent::__construct();
    }

    function listar() {
        $resultado = articulo::getArticulos();
        if (!$resultado) {
            parent::setErrores('No existen artículos para mostrar');
        } else {
            parent::setData($resultado);
        }
    }

}

?>