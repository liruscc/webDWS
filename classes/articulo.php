<?php

//Añadimos la librería funciones.php
require_once("funciones.php");

//Creamos la clase articulo con los mismos parámetros en el la tabla de la bbdd
class articulo {

    private $cod_articulo;
    private $descripcion;
    private $precio;
    private $promocion;
    private $activo;

    //Constructor para la clase cliente. 
    //Este constructor permite que cuando PDO hace el fetch a la clase cree los objetos sin argumentos,
    //Y que además podamos instancias un objeto cliente de forma manual.
    function __construct($cod_articulo = null, $descripcion = null, $precio = null, $promocion = null, $activo = null) {
        if ($cod_articulo !== null) {
            $this->cod_articulo = $cod_articulo;
        }

        if ($descripcion !== null) {
            $this->descripcion = $descripcion;
        }

        if ($precio !== null) {
            $this->precio = $precio;
        }

        if ($promocion !== null) {
            $this->promocion = $promocion;
        }

        if ($activo !== null) {
            $this->activo = $activo;
        }
    }

    //getters
    public function getCodigo() {
        return $this->cod_articulo;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getPromocion() {
        return $this->promocion;
    }

    public function getActivo() {
        return $this->activo;
    }

    //Setters
    public function setCodigo($codArticulo) {
        $this->cod_articulo = $codArticulo;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setPromocion($promocion) {
        $this->promocion = $promocion;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }

    //Método estático para recuperar todos productos de la bbdd 
    public static function imprimirArticulos($categoria = false) {
        $bbdd = connectBBDD();
        if (!$categoria) {
            $query = 'SELECT * FROM articulos';
            $articulos = executeQuery($bbdd, 'articulo', $query);
        } else {
            $query = 'SELECT * FROM articulos WHERE familia=:familia';
            $articulos = executeQuery($bbdd, 'articulo', $query, array(':familia' => $categoria));
        }

        return (count($articulos) > 0) ? $articulos : false;
    }

    //Método estático para recuperar todos productos de la bbdd 
    public static function imprimirArticulosPaginados($categoria = false, $subcategoria = false, $numArticulos, $pagina = 0) {
        $bbdd = connectBBDD();
        $inicio = $pagina * $numArticulos;
        $fin = $numArticulos;
        if ($categoria == true) {
            $query = 'SELECT * FROM articulos WHERE cod_articulo IN(SELECT articulo FROM articuloes WHERE familia=:familia)';
            $totalArticulos = executeQuery($bbdd, 'articulo', $query, array(':familia' => $categoria));
            if (count($totalArticulos) <= $numArticulos) {
                $query = 'SELECT * FROM articulos WHERE cod_articulo IN(SELECT articulo FROM articuloes WHERE familia=:familia)';
                $articulos = executeQuery($bbdd, 'articulo', $query, array(':familia' => $categoria));
            } else {
                $query = 'SELECT * FROM articulos WHERE cod_articulo IN(SELECT articulo FROM articuloes WHERE familia=:familia) LIMIT ' . $inicio . ',' . $fin;
                $articulos = executeQuery($bbdd, 'articulo', $query, array(':familia' => $categoria));
            }
        } elseif ($subcategoria == true) {
            $query = 'SELECT * FROM articulos WHERE cod_articulo IN(SELECT articulo FROM articuloes WHERE subfamilia=:subfamilia)';
            $totalArticulos = executeQuery($bbdd, 'articulo', $query, array(':subfamilia' => $subcategoria));
            if (count($totalArticulos) <= $numArticulos) {
                $query = 'SELECT * FROM articulos WHERE cod_articulo IN(SELECT articulo FROM articuloes WHERE subfamilia=:subfamilia)';
                $articulos = executeQuery($bbdd, 'articulo', $query, array(':subfamilia' => $subcategoria));
            } else {
                $query = 'SELECT * FROM articulos WHERE cod_articulo IN(SELECT articulo FROM articuloes WHERE subfamilia=:subfamilia) LIMIT ' . $inicio . ',' . $fin;
                $articulos = executeQuery($bbdd, 'articulo', $query, array(':subfamilia' => $subcategoria));
            }
        } else {
            $query = 'SELECT * FROM articulos';
            $totalArticulos = executeQuery($bbdd, 'articulo', $query);
            if (count($totalArticulos) <= $numArticulos) {
                $query = 'SELECT * FROM articulos';
                $articulos = executeQuery($bbdd, 'articulo', $query);
            } else {
                $query = 'SELECT * FROM articulos LIMIT ' . $inicio . ',' . $fin;
                $articulos = executeQuery($bbdd, 'articulo', $query);
            }
        }
        return (count($articulos) > 0 ) ? array($articulos, count($totalArticulos)) : false;
    }

    //Método estático para recuperar todos productos de la bbdd 
    public static function getArticulo($id) {
        $bbdd = connectBBDD();
        $query = 'SELECT * FROM articulos WHERE cod_articulo=:cod_articulo';
        $articulo = executeQuery($bbdd, 'articulo', $query, array(':cod_articulo' => $id));
        return (count($articulo) > 0) ? $articulo : false;
    }

    //Método estático para recuperar todos productos de la bbdd 
    public static function getArticulos() {
        $bbdd = connectBBDD();
        $query = 'SELECT * FROM articulos';
        $articulo = executeQuery($bbdd, 'articulo', $query);
        return (count($articulo) > 0) ? $articulo : false;
    }  

    public function updateArticulo() {
        $bbdd = connectBBDD();
        $query = "UPDATE articulos SET descripcion=:descripcion,precio=:precio,promocion=:promocion,activo=:activo WHERE cod_articulo=:cod";
        $parametros = array(':descripcion' => $this->descripcion, ':precio' => $this->precio, ':promocion' => $this->promocion, ':activo' => $this->activo, ':cod' => $this->cod_articulo);
        $articulo = executeUpdate($bbdd, $query, $parametros);
        //Validamos que devuelve el resultado correcto
        return $articulo === 1 ? true : false;
    }

    public static function buscarArticulos($cadena) {
        $bbdd = connectBBDD();
        $cadena = '%'.$cadena.'%';
        $query = "SELECT * FROM articulos WHERE descripcion LIKE :cadena";
        $parametros = array(':cadena' => $cadena);
        $articulos = executeQuery($bbdd,'articulo',$query,$parametros);
        //Validamos que devuelve el resultado correcto
        return count($articulos) > 0 ? array($articulos, count($articulos)) : false;
    }

    public function addArticulo() {
        $bbdd = connectBBDD();
        $query = "INSERT INTO articulos VALUES (:cod_articulo, :descripcion, :precio, :promocion, :activo)";
        $parametros = array(':cod_articulo' => $this->cod_articulo, ':descripcion' => $this->descripcion, ':precio' => $this->precio, ':promocion' => $this->promocion, ':activo' => $this->activo);
        $articulo = executeUpdate($bbdd,$query,$parametros);
        //Validamos que devuelve el resultado correcto
        return $articulo == 1 ? true : false;
    }

    public function cambiarEstado($estado) {
        $bbdd = connectBBDD();
        $query = "UPDATE articulos SET activo=:activo WHERE cod_articulo=:cod_articulo";
        $parametros = array(':cod_articulo' => $this->cod_articulo, ':activo' => $estado);
        $articulo = executeUpdate($bbdd, $query, $parametros);
        //Validamos que devuelve el resultado correcto
        return $articulo === 1 ? true : false;
    }

    public static function calcularImporte() {
        $numUnidades = 0;
        $total = 0;
        foreach ($_COOKIE["carrito"] as $ref => $unidades) {
            $articulo = articulo::getArticulo($ref);
            $importeArticulo = $articulo[0]->getPrecio() * $unidades;
            $numUnidades += $unidades;
            $total += $importeArticulo;
        }
        return $total;
    }

    public function validarArticulo() {
        $errores = Array();
        if (!self::existeCodigo($this->cod_articulo)) {
            $errores[] = "No se encontró el código del artículo.";
        }
        if (!self::validarDescripcion($this->descripcion)) {
            $errores[] = "La descripción es obligatoria y soporta un mínimo de 5 y un máximo de 40 carácteres.";
        }
        if (!self::validarPrecio($this->precio)) {
            $errores[] = "El precio es obligatorio, debe tener precisión de dos decimales y soporta un máximo de 10 carácteres.";
        }
        if (!self::validarPromocion($this->promocion)) {
            $errores[] = "El valor para la promoción no es válido. Debe ser '0 o '1'";
        }
        if (!self::validarActivo($this->activo)) {
            $errores[] = "El valor para el activo no es válido. Debe ser '0 o '1'";
        }
        return count($errores) > 0 ? $errores : false;
    }

    public function validarNuevoArticulo() {
        $errores = Array();
        if (self::existeCodigo($this->cod_articulo)) {
            $errores[] = "El código de artículo ya está en uso.";
        }
        if (!self::validarReferencia($this->cod_articulo)) {
            $errores[] = "El código de referencia introducido no es válido. Soporta mínimo 1 caracter y máximo 9";
        }
        if (!self::validarDescripcion($this->descripcion)) {
            $errores[] = "La descripción es obligatoria y soporta un mínimo de 5 y un máximo de 40 carácteres.";
        }
        if (!self::validarPrecio($this->precio)) {
            $errores[] = "El precio es obligatorio, debe tener precisión de dos decimales y soporta un máximo de 10 carácteres.";
        }
        if (!self::validarPromocion($this->promocion)) {
            $errores[] = "El valor para la promoción no es válido.";
        }
        if (!self::validarActivo($this->activo)) {
            $errores[] = "El valor para el activo no es válido.";
        }
        return count($errores) > 0 ? $errores : false;
    }

    public static function validarImagen($tipo_archivo, $tamano_archivo) {
        return !((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "png")) && ($tamano_archivo < 200000)) ?
                "El archivo debe ser de tipo [gif] [jpg] o [png] con un tamaño máximo de 200k." : false;
    }
    
    public static function validarReferencia($referencia) {
        return (strlen($referencia) < 10 && strlen($referencia) >0) ?
                "La referencia asociada al artículo no es válida." : false;
    }

    public static function existeCodigo($codigo) {
        return !self::getArticulo($codigo) ? false : true;
    }

    public static function validarDescripcion($descripcion) {
        return strlen($descripcion) > 4 && strlen($descripcion) < 41 ? true : false;
    }

    public static function validarPrecio($precio) {
        return preg_match('/\d{1,9}[.,]\d{2}$/', $precio) ? true : false;
    }

    public static function validarPromocion($promocion) {
        return preg_match('/[0-1]$/', $promocion) ? true : false;
    }

    public static function validarActivo($activo) {
        return preg_match('/[0-1]$/', $activo) ? true : false;
    }

}

?>