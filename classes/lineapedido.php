<?php

//Añadimos la librería funciones.php
require_once("funciones.php");
require_once("classes/pedido.php");
require_once("classes/articulo.php");

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
    public static function getPedido($cod_pedido) {
        $bbdd = connectBBDD();
        $query = 'SELECT * FROM linea_pedido WHERE cod_pedido=:cod_pedido';
        $parametros = array(':cod_pedido'=>$cod_pedido);
        $pedidos = executeQuery($bbdd, 'lineapedido', $query, $parametros);

        if (count($pedidos) > 0) {
            return $pedidos;
        } else {
            return false;
        }
    }
    
    public static function addLastLinea($cod_pedido, $cod_articulo, $unidades, $activo) {
        $num_linea=(int)self::getLastLinea($cod_pedido);
        $num_linea= $num_linea+1;
        $bbdd = connectBBDD();
       $query = 'INSERT INTO linea_pedido VALUES (:num_linea,:cod_pedido,:cod_articulo,:unidades,:activo)';
        $parametros = array(':num_linea' => $num_linea, ':cod_pedido' => $cod_pedido,
            ':cod_articulo' => $cod_articulo, ':unidades' => $unidades, ':activo' => $activo);
        $linea = executeUpdate($bbdd, $query, $parametros);
        //Validamos que devuelve el resultado correcto
        if ($linea == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function borrarLinea($cod_pedido, $num_linea) {
        $bbdd = connectBBDD();
        $query = 'DELETE FROM linea_pedido WHERE cod_pedido=:cod_pedido AND num_linea=:num_linea';
        $parametros = array(':num_linea' => $num_linea, ':cod_pedido' => $cod_pedido);
        $linea = executeUpdate($bbdd, $query, $parametros);
        //Validamos que devuelve el resultado correcto
        if ($linea == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function getLastLinea($cod_pedido){
        $bbdd = connectBBDD();
        $query = 'SELECT MAX(num_linea) AS max FROM linea_pedido WHERE cod_pedido=:cod_pedido';
        $parametros = array(':cod_pedido' => $cod_pedido);
        $num_linea=executeQuery($bbdd, 'lineapedido', $query, $parametros);
        if (count($num_linea) > 0) {
            return $num_linea[0]->max;
        } else {
            return false;
        }
    }
    
    public static function getLineaPedido($cod_pedido,$num_linea){
        $bbdd = connectBBDD();
        $query = 'SELECT * FROM linea_pedido WHERE cod_pedido=:cod_pedido AND num_linea=:num_linea';
        $parametros = array(':cod_pedido' => $cod_pedido,':num_linea' => $num_linea);
        $linea=executeQuery($bbdd, 'lineapedido', $query, $parametros);
        if (count($linea) > 0) {
            return $linea[0];
        } else {
            return false;
        }
    }

    public static function altaLinea($num_linea, $cod_pedido, $cod_articulo, $unidades, $activo) {
        $bbdd = connectBBDD();
        $query = 'INSERT INTO linea_pedido VALUES (:num_linea,:cod_pedido,:cod_articulo,:unidades,:activo)';
        $parametros = array(':num_linea' => $num_linea, ':cod_pedido' => $cod_pedido,
            ':cod_articulo' => $cod_articulo, ':unidades' => $unidades, ':activo' => $activo);
        $linea = executeUpdate($bbdd, $query, $parametros);

        //Validamos que devuelve el resultado correcto
        if ($linea == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function updateLineaPedido($num_linea, $cod_pedido, $cod_articulo, $unidades, $activo) {
        $bbdd = connectBBDD();
        $query = "UPDATE linea_pedido SET cod_articulo=:cod_articulo,unidades=:unidades,activo=:activo WHERE  num_linea=:num_linea AND cod_pedido=:cod_pedido";
        $parametros = array(':cod_pedido' =>$cod_pedido, ':cod_articulo' =>$cod_articulo, ':unidades' =>$unidades, ':activo' =>$activo,':num_linea'=>$num_linea);
        $linea = executeUpdate($bbdd, $query, $parametros);
        //Validamos que devuelve el resultado correcto
        return $linea == 1 ? true : false;
    }
    
    public static function validarLinea($num_linea, $cod_pedido, $cod_articulo, $unidades, $activo){
            $errores = array();
            
            if(!pedido::getPedido($cod_pedido)){
                $errores[] = 'El código de pedido no existe.';
            }
            if(!articulo::getArticulo($cod_articulo)){
                $mec= articulo::getArticulo($cod_articulo);
                $errores[] = 'El código de artículo no existe.';
            }
            
            if(self::validarUnidades($unidades)){
                echo "jaosjdaisds'" .$unidades."'"; 
                $errores[]='Las unidades deben ser un número entero. Menor que 100 y mayor que 0.';
            }
            
            if(self::validarActivo($activo)){
                $errores[]="El campo Activo admite valor '0' o '1'.'";
            }
            return $errores;
    }
    
    public static function validarUnidades($unidades){
        $unidades = (int)$unidades;
        if(is_int($unidades) && $unidades<100 && $unidades>0){
            return false;
        }else{
            return true;
        }
    }
    
    public static function validarActivo($activo) {
        $actRegex = '/[0-1]$/';
        if (!preg_match($actRegex, $activo)) {
            $resultado = true;
        } else {
            $resultado = false;
        }
        return $resultado;
    }
    

}

?>