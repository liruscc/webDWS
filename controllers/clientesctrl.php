<?php
require_once('controllers/mainctrl.php');
require_once('classes/cliente.php');

class clientesctrl extends mainctrl {

    function __construct() {
        parent::__construct('Clientes');
    }

    function listarClientes() {
        $resultado = cliente::getClientes();
        if (!$resultado) {
            parent::setErrores('No existen clientes para mostrar');
        } else {
            parent::setData($resultado);
        }
    }
    
    function listarEmpleados() {
        $resultado = cliente::getEmpleados();
        if (!$resultado) {
            parent::setErrores('No existen empleados para mostrar');
        } else {
            parent::setData($resultado);
        }
    }

}

?>