<?php
require_once('controllers/mainctrl.php');
require_once('classes/articulo.php');

class articulosctrl extends mainctrl {

    function __construct() {
        parent::__construct('Artículos');
    }

    function listar() {
        $resultado = articulo::getArticulos();
        if (!$resultado) {
            parent::setErrores('No existen artículos para mostrar');
        } else {
            parent::setData($resultado);
        }
    }
    
    function getArticulo($id) {
        $resultado = articulo::getArticulo($id);
        if (!$resultado) {
            parent::setErrores('No se pudo recuperar el artículo');
        } else {
            parent::setData($resultado);
        }
    }

}

?>