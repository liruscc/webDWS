<?php

if (isset($_GET["act"])) {
    $accion = $_GET["act"];
}

if (isset($_GET["ref"])) {
    $referencia = $_GET["ref"];
}

switch ($accion) {
    case 'up':
        agregarArticulo($referencia);
        break;
    case 'down':
        quitarArticulo($referencia);
        break;
    case 'delete':
        quitarTodosArticulos($referencia);
        break;
}

//Redirigimos al carrito 
header("Location: carrito.php");

function agregarArticulo($referencia) {
    setcookie("carrito[$referencia]", $_COOKIE["carrito"][$referencia] + 1, time() + 3600);
}

function quitarArticulo($referencia) {
    if ($_COOKIE["carrito"][$referencia] <= 1) {
        setcookie("carrito[$referencia]", $_COOKIE["carrito"][$referencia] + 1, time() - 3600);
    } else {
        setcookie("carrito[$referencia]", $_COOKIE["carrito"][$referencia] - 1, time() + 3600);
    }
}

function quitarTodosArticulos($referencia) {
    setcookie("carrito[$referencia]", $_COOKIE["carrito"][$referencia] + 1, time() - 3600);
}

?>