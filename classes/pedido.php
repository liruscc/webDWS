<?php

//Añadimos la librería funciones.php
require_once("funciones.php");

//Creamos la clase categoria con los mismos parámetros en el la tabla pedidos de la bbdd
class pedido {

    private $cod_pedido;
    private $dni_cliente;
    private $nombre;
    private $telefono;
    private $email;
    private $direccion;
    private $estado;
    private $tipo_pago;
    private $estado_pago;
    private $envio;
    private $activo;
    private $fecha_pedido;

    //Constructor para la clase pedido. 
    //Este constructor permite que cuando PDO hace el fetch a la clase cree los objetos sin argumentos,
    //Y que además podamos instancias un objeto cliente de forma manual.
    function __construct($cod_pedido = null, $dni_cliente = null, $nombre = null, $telefono = null, $email = null, $direccion = null, $estado = null, $tipo_pago = null, $estado_pago = null, $envio = null, $activo = null, $fecha_pedido = null) {
        if ($cod_pedido !== null) {
            $this->cod_pedido = $cod_pedido;
        }

        if ($dni_cliente !== null) {
            $this->dni_cliente = $dni_cliente;
        }
        
        if ($nombre !== null) {
            $this->nombre = $nombre;
        }
        
        if ($telefono !== null) {
            $this->telefono = $telefono;
        }
        
        if ($email !== null) {
            $this->email = $email;
        }
        
        if ($direccion !== null) {
            $this->direccion = $direccion;
        }

        if ($estado !== null) {
            $this->estado = $estado;
        }
        
        if ($tipo_pago !== null) {
            $this->tipo_pago = $tipo_pago;
        }
        
        if ($estado_pago !== null) {
            $this->estado_pago = $estado_pago;
        }

        if ($envio !== null) {
            $this->envio = $envio;
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
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function getTelefono() {
        return $this->telefono;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getDireccion() {
        return $this->direccion;
    }

    public function getEstado() {
        return $this->estado;
    }
    
    public function getTipoPago() {
        return $this->tipo_pago;
    }
    
    public function getEstadoPago() {
        return $this->estado_pago;
    }

    public function getEnvio() {
        return $this->envio;
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
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setDescripcion($activo) {
        $this->activo = $activo;
    }
    
    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setTipoPago($tipo_pago) {
        $this->tipo_pago = $tipo_pago;
    }
    
    public function setEstadoPago($estado_pago) {
        $this->tipo_pago = $estado_pago;
    }
    
    public function setEnvio($envio) {
        $this->tipo_pago = $envio;
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
    
    //Método estático para recuperar todos productos de un usuario 
    public static function getPedidosUsuario($dni) {
        $bbdd = connectBBDD();
        $query = 'SELECT * FROM pedidos WHERE dni_cliente=:dni';
        $parametros = array (':dni'=>$dni);
        $pedido = executeQuery($bbdd, 'pedido', $query,$parametros);
        return (count($pedido) > 0) ? $pedido : false;
    }

    public static function altaPedido($dniCliente, $nombre, $telefono, $email, $direccion, $tipo_pago, $envio) {
        $bbdd = connectBBDD();
        $estado = 'pagado';
        $estado_pago = 'confirmado';
        $activo= '1';
        $query = 'INSERT INTO pedidos (dni_cliente,nombre,telefono,email,direccion,estado,tipo_pago,estado_pago,envio,activo, fecha_pedido) VALUES (:dni_cliente,:nombre,:telefono,:email,:direccion,:estado,:tipo_pago,:estado_pago,:envio,:activo,NOW())';
        $parametros = array(':dni_cliente' => $dniCliente, ':nombre'=>$nombre, ':telefono'=>$telefono, ':email'=>$email, ':direccion'=>$direccion, ':estado' => $estado,
            ':tipo_pago'=>$tipo_pago, ':estado_pago'=>$estado_pago,':envio'=>$envio, ':activo' => $activo);
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