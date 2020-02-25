<?php
require_once('controllers/mainctrl.php');
require_once('classes/pedido.php');

class pedidosctrl extends mainctrl {

    function __construct() {
        parent::__construct('Pedidos');
    }

    function listar() {
        $resultado = pedido::getPedidos();
        if (!$resultado) {
            parent::setErrores('No existen pedidos para mostrar');
        } else {
            parent::setData($resultado);
        }
    }
    
     function listarUsuario($dni) {
        $resultado = pedido::getPedidosUsuario($dni);
        if (!$resultado) {
            parent::setErrores('No existen pedidos para mostrar');
        } else {
            parent::setData($resultado);
        }
    }

}

?>