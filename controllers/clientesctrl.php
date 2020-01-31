<?php
require_once('controllers/mainctrl.php');
require_once('classes/cliente.php');

class clientctrl extends mainctrl {

    function __construct() {
        parent::__construct();
    }

    function listarClientes() {
        $resultado = cliente::getClientes();
        if (!$resultado) {
            parent::setErrores('No existen clientes para mostrar');
        } else {
            parent::setData($resultado);
        }
    }

}

?>