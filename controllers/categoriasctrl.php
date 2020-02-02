<?php
require_once('controllers/mainctrl.php');
require_once('classes/categoria.php');

class categoriasctrl extends mainctrl {

    function __construct() {
        parent::__construct('Categorías');
    }

    function listar() {
        $resultado = categoria::getCategorias(false);
        if (!$resultado) {
            parent::setErrores('No existen categorías para mostrar');
        } else {
            parent::setData($resultado);
        }
    }

}

?>