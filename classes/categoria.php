<?php

//Añadimos la librería funciones.php
require_once("funciones.php");

//Creamos la clase categoria con los mismos parámetros en el la tabla familias de la bbdd
class categoria {

    private $cod_familia;
    private $nombre;
    private $activo;

    //Constructor para la clase categorias. 
    //Este constructor permite que cuando PDO hace el fetch a la clase cree los objetos sin argumentos,
    //Y que además podamos instancias un objeto cliente de forma manual.
    function __construct($nombre = null, $activo = null,$cod_familia = null) {
        if ($cod_familia !== null) {
            $this->cod_familia = $cod_familia;
        }

        if ($nombre !== null) {
            $this->nombre = $nombre;
        }

        if ($activo !== null) {
            $this->activo = $activo;
        }
    }

    //getters
    public function getCodigo() {
        return $this->cod_familia;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getActivo() {
        return $this->activo;
    }

    //Setters
    public function setCodigo($codFamilia) {
        $this->cod_familia = $codFamilia;
    }

    public function setFamilia($familia) {
        $this->familia = $familia;
    }

    public function setDescripcion($activo) {
        $this->activo = $activo;
    }

    //Imprimir categoría
    public function __toString() {
        return $this->getNombre();
    }

    public static function getCategoria($id, $activo = true) {
        if (!$activo) {
            $bbdd = connectBBDD();
            $query = 'SELECT * FROM familias WHERE cod_familia=:cod_familia';
            $articulo = executeQuery($bbdd, 'categoria', $query, array(':cod_familia' => $id));
        } else {
            $bbdd = connectBBDD();
            $query = 'SELECT * FROM familias WHERE cod_familia=:cod_familia AND activo=:activo';
            $articulo = executeQuery($bbdd, 'categoria', $query, array(':cod_familia' => $id, ':activo' => 1));
        }
        return (count($articulo) > 0) ? $articulo[0] : false;
    }

    //Método estático para recuperar todas las categorias de la bbdd 
    public static function getCategorias($activo = true) {
        if (!$activo) {
            $bbdd = connectBBDD();
            $query = 'SELECT * FROM familias';
            $categorias = executeQuery($bbdd, 'categoria', $query);
        } else {
            $bbdd = connectBBDD();
            $query = 'SELECT * FROM familias WHERE activo = 1';
            $categorias = executeQuery($bbdd, 'categoria', $query);
        }
        return (count($categorias) > 0) ? $categorias : false;
    }

    //Sacar el activo del update y poner botón ON OFF
    public function updateCategoria() {
        $bbdd = connectBBDD();
        $query = "UPDATE familias SET cod_familia=:cod_familia,nombre=:nombre,activo=:activo WHERE cod_familia=:cod_familia";
        $parametros = array(':cod_familia' => $this->cod_familia, ':nombre' => $this->nombre, ':activo' => $this->activo);
        $articulo = executeUpdate($bbdd, $query, $parametros);
        //Validamos que devuelve el resultado correcto
        return $articulo > 0 ? true : false;
    }

    public function buscarCategorias($cadena) {
        $bbdd = connectBBDD();
        $query = "SELECT cod_familias FROM categorias WHERE nombre LIKE=:cadena";
        $parametros = array(':nombre' => $cadena);
        $categorias = executeQuery($bbdd, $query, 'categoria', $parametros);
        //Validamos que devuelve el resultado correcto
        return (count($categorias) > 0) ? $categorias : false;
    }

    public function addCategoria() {
        $activo="1";
        $bbdd = connectBBDD();
        $query = "INSERT INTO familias (nombre, activo) VALUES (:nombre, :activo)";
        $parametros = array(':nombre' => $this->nombre, ':activo' => $activo);
        $articulo = executeUpdate($bbdd, $query, $parametros);
        $index= $bbdd->lastInsertId();
        //Validamos que devuelve el resultado correcto
        return $articulo > 0 ? $index : false;
    }

    //!hacerlo recursivo para las sub que cuelgan, y llamar  las sub que llaman a los artículos
    public function cambiarEstado($estado) {
        $bbdd = connectBBDD();
        $query = "UPDATE familias SET activo=:activo WHERE cod_familia=:cod_familia";
        $parametros = array(':cod_familia' => $this->cod_familia, ':activo' => $estado);
        $articulo = executeUpdate($bbdd, $query, $parametros);
        //Validamos que devuelve el resultado correcto
        return $articulo > 0 ? true : false;
    }

    public function validarNuevaCategoria() {
        $errores = Array();
        if (!self::validarNombre($this->nombre)) {
            $errores[] = "La nombre es obligatorio y soporta un mínimo de 5 y un máximo de 20 carácteres.";
        }
        return $errores ? $errores:false;
    }

    public static function existeCodigo($codigo) {
        return !self::getCategoria($codigo) ? false : true;
    }

    public static function validarNombre($nombre) {
        return strlen($nombre) > 4 && strlen($nombre) < 21 ? true : false;
    }

    public static function validarPromocion($promocion) {
        return preg_match('/[0-1]$/', $promocion) ? true : false;
    }

    public static function validarActivo($activo) {
        return preg_match('/[0-1]$/', $activo) ? true : false;
    }

}

?>