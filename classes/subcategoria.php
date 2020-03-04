<?php

//Añadimos la librería funciones.php
require_once("funciones.php");
require_once("categoria.php");

//Creamos la clase categoria con los mismos parámetros en el la tabla familias de la bbdd
class subcategoria {

    private $cod_subfamilia;
    private $familia;
    private $nombre;
    private $activo;

    //Constructor para la clase categorias. 
    //Este constructor permite que cuando PDO hace el fetch a la clase cree los objetos sin argumentos,
    //Y que además podamos instancias un objeto cliente de forma manual.
    function __construct($cod_subfamilia = null, $familia = null, $nombre = null, $activo = null) {
        if ($cod_subfamilia !== null) {
            $this->cod_subfamilia = $cod_subfamilia;
        }
        if ($familia !== null) {
            $this->familia = $familia;
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
        return $this->cod_subfamilia;
    }

    public function getFamilia() {
        return $this->familia;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getActivo() {
        return $this->activo;
    }

    //Setters
    public function setCodigo($codFamilia) {
        $this->cod_subfamilia = $cod_subfamilia;
    }

    public function setNombre($familia) {
        $this->nombre = $nombre;
    }

    public function setFamilia($familia) {
        $this->familia = $familia;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }

    //Imprimir categoría
    public function __toString() {
        return $this->getNombre();
    }
    
    public static function getAll() {
        $bbdd = connectBBDD();
        $query = 'SELECT * FROM subfamilias';
        $articulo = executeQuery($bbdd, 'subcategoria', $query);
        return (count($articulo) > 0) ? $articulo : false;
    }

    public static function getSubCategoria($id) {
        $bbdd = connectBBDD();
        $query = 'SELECT * FROM subfamilias WHERE cod_subfamilia=:cod_subfamilia';
        $articulo = executeQuery($bbdd, 'subcategoria', $query, array(':cod_subfamilia' => $id));
        return (count($articulo) > 0) ? $articulo[0] : false;
    } 

    public static function getSubcategorias($categoria) {
        $bbdd = connectBBDD();
        $query = 'SELECT * FROM subfamilias WHERE familia=:familia';
        $parametros = array(':familia' => $categoria->getCodigo());
        $subcategorias = executeQuery($bbdd, 'subcategoria', $query, $parametros);

        return (count($subcategorias) > 0) ? $subcategorias : false;
    }
    
    public function updateSubCategoría($cod) {
        $bbdd = connectBBDD();
        $query = "UPDATE subfamilias SET cod_subfamilia=:cod_subfamilia,familia=:familia,nombre=:nombre,activo=:activo WHERE cod_subfamilia=:cod_subfamilia";
        $parametros = array(':cod_subfamilia' => $this->cod_subfamilia, ':familia'=>$this->familia,':nombre' => $this->nombre, ':activo' => $this->activo);
        $subcategoria = executeUpdate($bbdd, $query, $parametros);
        //Validamos que devuelve el resultado correcto
        return $subcategoria === 1 ? true : false;
    }

    public function buscarSubCategorias($cadena) {
        $bbdd = connectBBDD();
        $query = "SELECT cod_subfamilias FROM subfamilias WHERE nombre LIKE=:cadena";
        $parametros = array(':nombre' => $cadena);
        $subcategoria = executeQuery($bbdd, $query, 'subcategoria', $parametros);
        //Validamos que devuelve el resultado correcto
        return (count($subcategoria) > 0) ? $subcategoria : false;
    }

    public function addSubCategoria() {
        $bbdd = connectBBDD();
        $query = "INSERT INTO subfamilias (familia, nombre, activo) VALUES (:familia, :nombre, :activo)";
        $parametros = array(':familia' => $this->familia, ':nombre' => $this->nombre, ':activo' => $this->activo);
        $articulo = executeUpdate($bbdd, $query, $parametros);
        //Validamos que devuelve el resultado correcto
        return $articulo == 1 ? true : false;
    }
    //!hacerlo recursivo para las sub que cuelgan, y llamar  las sub que llaman a los artículos
    public function cambiarEstado($estado) {
        $bbdd = connectBBDD();
        $query = "UPDATE subfamilias SET activo=:activo WHERE cod_subfamilia=:cod_subfamilia";
        $parametros = array(':cod_subfamilia' => $this->cod_subfamilia, ':activo' => $estado);
        $articulo = executeUpdate($bbdd, $query, $parametros);
        //Validamos que devuelve el resultado correcto
        return $articulo == 1 ? true : false;
    }

}

?>