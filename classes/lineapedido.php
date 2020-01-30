<?php

//Añadimos la librería funciones.php
require_once("funciones.php");

//Creamos la clase categoria con los mismos parámetros en el la tabla linea pedido de la bbdd
class lineapedido {

    private $num_linea;
    private $cod_pedido;
    private $cod_articulo;
    private $unidades;
    private $activo;

    //Constructor para la clase linea de pedido. 
    //Este constructor permite que cuando PDO hace el fetch a la clase cree los objetos sin argumentos,
    //Y que además podamos instancias un objeto cliente de forma manual.
    function __construct($num_linea = null, $cod_pedido = null, $cod_articulo = null, $unidades = null, $activo = null) {

        if ($num_linea !== null) {
            $this->num_linea = $num_linea;
        }

        if ($cod_pedido !== null) {
            $this->cod_pedido = $cod_pedido;
        }

        if ($cod_articulo !== null) {
            $this->cod_articulo = $cod_articulo;
        }

        if ($unidades !== null) {
            $this->unidades = $unidades;
        }

        if ($activo !== null) {
            $this->activo = $activo;
        }
    }

    //getters
    public function getLinea() {
        return $this->num_linea;
    }

    public function getCodigoPedido() {
        return $this->cod_pedido;
    }

    public function getCodigoArticulo() {
        return $this->cod_articulo;
    }

    public function getUnidades() {
        return $this->unidades;
    }

    public function getActivo() {
        return $this->activo;
    }

    //Setters
    public function setLinea($linea) {
        $this->num_linea = $num_linea;
    }

    public function setCodigoPedido($cod_pedido) {
        $this->cod_pedido = $cod_pedido;
    }

    public function setCodigoArticulo($cod_articulo) {
        $this->cod_articulo = $cod_articulo;
    }

    public function setUnidades($unidades) {
        $this->unidades = $unidades;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }

    //Imprimir linea
    public function __toString() {
        return $this->getCodigoArticulo() . ' ' . $this->getUnidades();
    }

    //Método estático para recuperar todas las líneas de un pedido 
    public static function getPedido($codpedido) {
        $bbdd = connectBBDD();
        $query = 'SELECT * FROM linea_pedido';
        $pedidos = executeQuery($bbdd, 'lineapedido', $query);

        if (count($pedidos) > 0) {
            return $pedidos;
        } else {
            return false;
        }
    }

    public static function altaLinea($num_linea, $cod_pedido, $cod_articulo, $unidades, $activo) {
        $bbdd = connectBBDD();
        $query = 'INSERT INTO linea_pedido VALUES (:num_linea,:cod_pedido,:cod_articulo,:unidades,:activo)';
        $parametros = array(':num_linea' => $num_linea, ':cod_pedido' => $cod_pedido,
            ':cod_articulo' => $cod_articulo, ':unidades' => $unidades, ':activo' => $activo);
        $cliente = executeUpdate($bbdd, $query, $parametros);

        //Validamos que devuelve el resultado correcto
        if ($cliente == 1) {
            return true;
        } else {
            return false;
        }
    }

}

?>