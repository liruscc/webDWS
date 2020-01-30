<?php

require_once('classes/pedido.php');
require_once('classes/lineapedido.php');

$altapedido = false;
$altalineas = false;

$altapedido = pedido::altaPedido('12345678X', 'pagado', '1');

if ($altapedido) {
    $i = 1;
    foreach ($_COOKIE["carrito"] as $ref => $unidades) {
        $altalineas = lineapedido::altaLinea($i, $altapedido, $ref, $unidades, '1');
        $i++;
    }
}

if ($altapedido && $altalineas) {
    foreach ($_COOKIE["carrito"] as $ref => $unidades) {// la recorro y borro las cookies
        setcookie("carrito[$ref]", "0", time() - 1);
    }
}

//Redirigimos a la tienda
header("Location: index.php");
?>