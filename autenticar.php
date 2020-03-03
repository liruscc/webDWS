<?php

require_once('classes/cliente.php');
session_start();

//Login
if ($_POST) {

    $usuario = new Cliente();

    $errores = cliente::validarLogin($_POST['usuario'], $_POST['password']);
    if (!$errores) {
        $usuario = Cliente::verificarPassword($_POST['usuario'], $_POST['password']);
        // si el id del objeto retornado no es null, quiere decir que encontro un registro en la base
        if ($usuario->getActivo() == '1') {

            if ($usuario) {
                $_SESSION['id'] = $usuario->getDni();
                $_SESSION['tipo'] = $usuario->getTipo();
                header('Location: index.php?correcto');
            } else {
                session_destroy();
                header('Location: index.php?error=El usuario o parssword no son correctos.'); // cuando los datos son incorrectos envia a la página de error
            }
        } else {
            session_destroy();
            header('Location: index.php?error=El usuario está bloqueado.'); // cuando los datos son incorrectos envia a la página de error
        }
    } else {
        session_destroy();
        header('Location: index.php?error=El usuario o parssword no son correctos.'); // cuando los datos son incorrectos envia a la página de error
    }
}

//Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php'); // cuando los datos son incorrectos envia a la 
}
?>