<?php

//Añadimos la librería funciones.php
require_once("funciones.php");

//Creamos la clase categoria con los mismos parámetros en el la tabla pedidos de la bbdd
class pedido {

    private $cod_pedido;
    private $dni_cliente;
    private $estado;
    private $activo;
    private $fecha_pedido;

    //Constructor para la clase pedido. 
    //Este constructor permite que cuando PDO hace el fetch a la clase cree los objetos sin argumentos,
    //Y que además podamos instancias un objeto cliente de forma manual.
    function __construct($cod_pedido = null, $dni_cliente = null, $estado = null, $activo = null, $fecha_pedido = null) {
        if ($cod_pedido !== null) {
            $this->cod_pedido = $cod_pedido;
        }

        if ($dni_cliente !== null) {
            $this->dni_cliente = $dni_cliente;
        }

        if ($estado !== null) {
            $this->estado = $estado;
        }

        if ($activo !== null) {
            $this->activo = $activo;
        }

        if ($fecha_pedido !== null) {
            $this->fecha_pedido = $fecha_pedido;
        }
    }

    //getters
    public function getCodigo() {
        return $this->cod_pedido;
    }

    public function getDni() {
        return $this->dni_cliente;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function getFecha() {
        return $this->fecha_pedido;
    }

    //Setters
    public function setCodigo($codPedido) {
        $this->cod_pedido = $cod_pedido;
    }

    public function setDni($dni) {
        $this->dni_cliente = $dni_cliente;
    }

    public function setDescripcion($activo) {
        $this->activo = $activo;
    }

    //Imprimir categoría
    public function __toString() {
        return $this->getCodigo();
    }

    //Método estático para recuperar todos los pedidos de la bbdd 
    public static function getPedidos() {
        $bbdd = connectBBDD();
        $query = 'SELECT * FROM pedidos';
        $pedidos = executeQuery($bbdd, 'pedido', $query);

        if (count($pedidos) > 0) {
            return $pedidos;
        } else {
            return false;
        }
    }

    public static function altaPedido($dniCliente, $estado, $activo) {
        $bbdd = connectBBDD();
        $query = 'INSERT INTO pedidos (dni_cliente,estado,activo, fecha_pedido) VALUES (:dni_cliente,:estado,:activo,NOW())';
        $parametros = array(':dni_cliente' => $dniCliente, ':estado' => $estado,
            ':activo' => $activo);
        $cliente = executeUpdate($bbdd, $query, $parametros);
        $idpedido = $bbdd->lastInsertId();
        //Validamos que devuelve el resultado correcto
        if ($cliente == 1) {
            return $idpedido;
        } else {
            return false;
        }
    }

}

?>