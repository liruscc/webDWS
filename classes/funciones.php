<?php
require_once 'config.php';
//Función para conectar con la BBDD
function connectBBDD() {
    global $host;
    global $db;
    global $user;
    global $pass;
    
    try {
        $conexion = new PDO('mysql:host=' . $host . ';dbname=' . $db . ";charset=utf8", $user, $pass);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch (PDOException $exc) {
        echo 'Error al conectar con la BBDD: ' . $exc->getMessage();
    }
}

//Función para ejecutar consultas que devuelven datos en la BBDD
//Requiere conexión, consulta para preaparar y parámetros si existen (opcional)
function executeQuery($conexion, $class, $consulta, $parametros = false) {
    try {
        $stmt = $conexion->prepare($consulta);

        if (!$parametros) {
            $stmt->execute();
        } else {
            $stmt->execute($parametros);
        }

        $stmt->setFetchMode(PDO::FETCH_CLASS, $class);
        $clientes = Array();

        while ($cliente = $stmt->fetch()) {
            $clientes[] = $cliente;
        }
        return $clientes;
    } catch (PDOException $exc) {
        echo 'Error al ejecutar la query: ' . $exc->getMessage();
    }
}

//Función para ejecutar consultas que NO devuelven datos en la BBDD
//Requiere conexión, consulta para preaparar y parámetros si existen (opcional)
function executeUpdate($conexion, $consulta, $parametros = false) {
    try {
        $stmt = $conexion->prepare($consulta);

        if (!$parametros) {
            $result = $stmt->execute();
        } else {
            $result = $stmt->execute($parametros);
        }
        return $result;
    } catch (PDOException $exc) {
        echo 'Error al ejecutar la query: ' . $exc->getMessage();
    }
}

?>